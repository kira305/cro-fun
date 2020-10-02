<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\global_info;
use App\User;
use App\Cost_MST;
use App\Company_MST;
use App\Customer_MST;
use App\Project_MST;
use App\Department_MST;
use App\Diagram;
use Auth;
use Response;
use Helper;
use DB;
use Common;
use Crofun;
use DateTime;
use Carbon\Carbon;
use App\Service\CustomerService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*  public function __construct()
    {
        $this->middleware('auth');
    }*/
    protected $customer_service;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customer_service)
    {
        //$this->middleware('auth');
        $this->customer_service   = $customer_service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provis_array = array();
        $credit_array = array();

        $global_info = global_info::select('global_info.*');
        $global_info->where('start_date', '<=', date('Y/m/d H:i:s'))->where('end_date', '>=', date('Y/m/d H:i:s'));
        $global_info->where('delete_flg', 0);
        $global_info = $global_info->orderBy('important_flg', 'asc')->orderBy('id', 'desc')->get();
        foreach ($global_info as $key => $value) {
            $global_info[$key]->global_info_content_change = $this->replaceUrl($value->global_info_content);
        }

        //顧客情報の取得
        $usr_id      = Auth::user()->id;

        //所属している全会社を表示
        /*$company_id  = Common::checkUserCompany($usr_id); */

        //本務の会社情報のみ表示
        $company_id  = Auth::user()->company_id;

        $customer    = Customer_MST::where('company_id', $company_id)->where('status', 4)->orderBy('id', 'desc')->get();



        //売掛金残オーバー顧客
        $customers = $this->customer_service->crediteslatest(array($company_id));
        $customers = $customers->get();
        //配列の初期化
        $over_receivable  = array();
        $transaction_date = array();
        $receivable_date  =  array();
        foreach ($customers as $customer_date) {

            $temp = Project_MST::leftjoin('customer_mst', 'customer_mst.id', '=', 'project_mst.client_id')
                ->where('client_id', $customer_date->client_id)
                ->where('project_mst.status', 'true');

            //取引想定額
            $credit_expect = $temp->where('project_mst.status', 'true')->where('project_mst.status', 'true')->sum('transaction_money');

            //  $credit_expect = Project_MST::leftjoin('customer_mst','customer_mst.id','=','project_mst.client_id')
            //     ->where('client_id', $customer_date->client_id)
            //     ->where('project_mst.status','true')
            //     ->sum('transaction_money');
            //単発
            $transaction_shot = $temp->where('project_mst.once_shot', 'true')->sum('transaction_shot');
            //   $transaction_shot = Project_MST::leftjoin('customer_mst','customer_mst.id','=','project_mst.client_id')
            //         ->where('client_id', $customer_date->client_id)
            //         ->where('project_mst.status','true')
            //         ->where('project_mst.once_shot','true')
            //         ->sum('transaction_shot');

            $transaction =  $credit_expect + $transaction_shot;
            $creditExpect = $customer_date->credit_check()->credit_expect;
            $newestReceivable = $customer_date->newnestReceivable();

            if (($creditExpect != null) && ($newestReceivable != null)) {
                //取引想定額が与信限度額より超えるか。
                if ($transaction > $creditExpect) {

                    $transaction_date[$customer_date->id] = $transaction;
                    $over_receivable[$customer_date->id] = $customer_date;

                    if (empty($newestReceivable) == false) {
                        $receivable_date[$customer_date->id] = $newestReceivable;
                    }
                } else {
                    //与信限度額が最新の売掛金残より超えるか。

                    if (empty($newestReceivable) == false) {

                        if ($newestReceivable->receivable > $creditExpect) {

                            $transaction_date[$customer_date->id] = $transaction;
                            $over_receivable[$customer_date->id] = $customer_date;
                            $receivable_date[$customer_date->id] = $newestReceivable;
                        } else {
                            $receivable_date[$customer_date->id] = $newestReceivable;
                        }
                    }
                }
            }
        }
        return view('home.home', ["global_info" => $global_info, "provis_array" => $provis_array, "global_info" => $global_info, "customer" => $customer, "over_receivable" => $over_receivable, "transaction_date" => $transaction_date, "receivable_date" => $receivable_date]);
    }

    public function showChangePasswordForm()
    {

        return view('auth.changepassword');
    }

    public static function  replaceUrl($chn_data)
    {
        $chn_data = htmlspecialchars($chn_data, ENT_QUOTES);
        $chn_data = nl2br($chn_data);
        //•¶Žš—ñ‚ÉURL‚ª¬‚¶‚Á‚Ä‚¢‚éê‡‚Ì‚Ý‰º‚ÌƒXƒNƒŠƒvƒg”­“®
        if (preg_match("/(http|https):\/\/[-\w\.]+(:\d+)?(\/[^\s]*)?/", $chn_data)) {
            preg_match_all("/(http|https):\/\/[-\w\.]+(:\d+)?(\/[^\s]*)?/", $chn_data, $pattarn);
            foreach ($pattarn[0] as $key => $val) {
                $replace[] = '<a href="' . $val . '" target="_blank">' . $val . '</a>';
            }
            $chn_data = str_replace($pattarn[0], $replace, $chn_data);
        }
        return $chn_data;
    }
}
