<?php

namespace App\Service;

use App\User;
use App\Concurrently;
use App\Customer_MST;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Carbon\Carbon;
use Auth;
use Common;
use DB;
use App\Credit_check;
use Exception;

class CustomerService
{

    private   $customerRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * get all customer in first time load page
     *
     * return list of customers
     **/

    public function getAllCustomer()
    {

        $usr_id      = Auth::user()->id;
        $company_id  = Common::checkUserCompany($usr_id);
        $customers   = Customer_MST::leftjoin('customer_name', 'customer_mst.id', '=', 'customer_name.client_id')
            ->whereIn('company_id', $company_id)
            ->select('*', 'customer_mst.id as me_id', 'client_name_hankaku_s as search_name', 'customer_name.created_at as created_time')
            ->orderBy('status', 'desc')
            ->orderBy('customer_mst.id', 'desc')
            ->paginate(25);

        return $customers;
    }
    // search customer's information by condition
    /**
     * $company_id_s 会社　id
     * $client_code 顧客コード
     * $client_name 顧客名かな
     * $corporation_num 法人番号
     * $sale 取引区分
     * $status
     * return 顧客情報の配列
     **/
    public function search($company_id_s, $client_code, $client_name, $corporation_num, $sale, $status)
    {

        $usr_id      = Auth::user()->id;
        $company_id  = Common::checkUserCompany($usr_id);

        $customers   = Customer_MST::leftjoin('customer_name', 'customer_mst.id', '=', 'customer_name.client_id')
            ->whereIn('customer_mst.company_id', $company_id)
            ->where('del_flag', false)
            ->select('*', 'customer_mst.id as me_id', 'client_name_hankaku_s as search_name', 'customer_name.created_at as created_time')
            ->orderBy('status', 'desc')
            ->orderBy('customer_mst.id', 'desc')
            ->when($client_code != "", function ($query) use ($client_code) {

                return $query->where('client_code', $client_code)->orwhere('client_code_main', $client_code);
            });

        if ($company_id_s != "") {

            $customers = $customers->where('company_id', $company_id_s);
        }

        // if($client_code != ""){

        //     // $customers = $customers->where('client_code',$client_code)->orwhere('client_code_main',$client_code);
        //     $customers = $customers->where('client_code',$client_code)->where(function ($query) use($client_code) {
        //     $query->orwhere('client_code_main', $client_code);
        //     });

        //  }

        if ($client_name != "") {

            $customers = $customers->where('client_name_hankaku_s', 'like', "%$client_name%");
        }

        if ($corporation_num != "") {

            // $customers = $customers->where('corporation_num',$corporation_num);

            $customers = $customers->where('corporation_num', $corporation_num);
        }

        if ($sale != "") {

            $customers = $customers->where('sale', $sale);
        }

        if ($status != "") {

            $customers = $customers->where('status', $status);
        }

        return $customers->paginate(25);
    }
    // check session is existed , if existed return 1 else return 0
    public function checkSessionExist($request)
    {

        if (
            $request->session()->exists('company_id_c')     ||
            $request->session()->exists('customer_code_c')  ||
            $request->session()->exists('customer_name_c')  ||
            $request->session()->exists('personal_code_c')  ||
            $request->session()->exists('sale')             ||
            $request->session()->exists('status')
        ) {

            return 1;
        } else {

            return 0;
        }
    }
    // get all serch condition to array
    public function getSearchCondition($request)
    {

        $condition = array();

        if ($request->session()->exists('company_id_c')) {

            array_push($condition, session('company_id_c'));
        } else {

            array_push($condition, "");
        }

        if ($request->session()->exists('customer_code_c')) {

            array_push($condition, session('customer_code_c'));
        } else {

            array_push($condition, "");
        }

        if ($request->session()->exists('customer_name_c')) {

            array_push($condition, session('customer_name_c'));
        } else {

            array_push($condition, "");
        }

        if ($request->session()->exists('personal_code_c')) {

            array_push($condition, session('personal_code_c'));
        } else {

            array_push($condition, "");
        }

        if ($request->session()->exists('sale')) {

            array_push($condition, session('sale'));
        } else {

            array_push($condition, "");
        }

        if ($request->session()->exists('status')) {

            array_push($condition, session('status'));
        } else {

            array_push($condition, "");
        }

        return $condition;
    }

    // check clinet is existed
    public function checkCustomerExist($id)
    {

        $customer = Customer_MST::where('client_code', $id)->get();

        if ($customer) {

            return 1;
        } else {

            return 0;
        }
    }

    public function getCustomerById($id)
    {

        $customer = Customer_MST::where('id', $id)->first();

        if ($customer) {

            return $customer;
        } else {

            return 0;
        }
    }

    // search customer's information by condition
    /**
     * $get_time 取得時刻
     * $rank リスモンのrank
     * return 更新期間
     **/
    public function getRenewTimeRM($get_time, $rank, $credit_expect, $credit_limit)
    {
        if ($rank == 'G') return null;

        $newDate        = date("Y-m-d", strtotime($get_time));
        $d              = date_parse_from_format("Y-m-d", $newDate);
        $month          = $d["month"];
        $day            = $d["day"];
        $year           = $d["year"];

        if ($rank == 'A' || $rank == 'B' || $rank == 'C' || $rank == 'D') {
            if ($credit_expect > $credit_limit) {

                if ($month <= 2) {

                    $month_next = 3;
                } elseif ($month <= 8) {

                    $month_next = 9;
                } elseif ($month <= 12) {

                    $year       = $year + 1;
                    $month_next = 3;
                }
                $renew_date = $year . '-' . $month_next . '-01';

                $time = Carbon::parse($renew_date)->format('Y-m-d');

                return $time;
            } else {
                $year       = $year + 1;
                $month_next = 9;
                $renew_date = $year . '-' . $month_next . '-01';

                $time = Carbon::parse($renew_date)->format('Y-m-d');

                return $time;
            }
        }

        if ($rank == 'E1' || $rank == 'F1' || $rank == 'E2' || $rank == 'F2' || $rank == 'F3' || $rank == 'E') {

            if ($month <= 2) {

                $month_next = 3;
            } elseif ($month <= 8) {

                $month_next = 9;
            } elseif ($month <= 12) {

                $year       = $year + 1;
                $month_next = 3;
            }
            $renew_date = $year . '-' . $month_next . '-01';

            $time = Carbon::parse($renew_date)->format('Y-m-d');

            return $time;
        }
    }

    // search customer's information by condition
    /**
     * $get_time 取得時刻
     * $rank TDBのrank
     * return 更新期間
     **/
    public function getRenewTimeTDB($get_time, $rank)
    {
        $newDate        = date("Y-m-d", strtotime($get_time));
        $d              = date_parse_from_format("Y-m-d", $newDate);
        $month          = $d["month"];
        $day            = $d["day"];
        $year           = $d["year"];

        if ($rank == 'E') {

            if ($month <= 2) {
                $month_next = 3;
            } elseif ($month <= 8) {

                $month_next = 9;
            } elseif ($month <= 12) {

                $year       = $year + 1;
                $month_next = 3;
            }
            $renew_date = $year . '-' . $month_next . '-01';

            $time = Carbon::parse($renew_date)->format('Y-m-d');

            return $time;
        } else {
            $year       = $year + 1;
            $month_next = 9;
            $renew_date = $year . '-' . $month_next . '-01';

            $time = Carbon::parse($renew_date)->format('Y-m-d');

            return $time;
        }
    }
    // search customer's information by condition
    /**
     * $rank リスモンのrank
     * return 星の数
     **/
    public function credit_rank($rank)
    {
        $credit_rank = null;
        if ($rank == 'A') {

            $credit_rank = '☆☆☆☆☆';
        }

        if ($rank == 'B') {

            $credit_rank = '☆☆☆☆';
        }

        if ($rank == 'C') {

            $credit_rank = '☆☆☆';
        }

        if ($rank == 'D') {

            $credit_rank = '☆☆';
        }
        if ($rank == 'E1') {

            $credit_rank = '☆';
        }
        if ($rank == 'E2') {

            $credit_rank = '☆';
        }
        if ($rank == 'F1') {

            $credit_rank = '☆';
        }

        if ($rank == 'F2') {

            $credit_rank = '☆';
        }

        if ($rank == 'F3') {
            $credit_rank = '☆';
        }

        if ($rank == 'G') {

            $credit_rank = '??';
        }
        if ($rank == 'E') {

            $credit_rank = '☆';
        }

        return $credit_rank;
    }

    public function credit_rank_TSR($rank)
    {
        if ($rank >= 80) {

            $credit_rank = '☆☆☆☆☆';
        } elseif ($rank >= 65) {

            $credit_rank = '☆☆☆☆';
        } elseif ($rank >= 50) {

            $credit_rank = '☆☆☆';
        } elseif ($rank >= 30) {

            $credit_rank = '☆☆';
        } elseif ($rank < 30) {

            $credit_rank = '☆';
        }


        return $credit_rank;
    }
    //配列に顧客情報を入れる // change customer information to array
    /**
     * $customer_id  顧客id
     *
     * return array data of customer
     **/
    public function changeFormatData($customer_id)
    {

        $customer       = Customer_MST::where('id', $customer_id)->first();

        $customer_array = array();

        array_push($customer_array, $customer->client_name);
        array_push($customer_array, $customer->client_name_kana);
        array_push($customer_array, $customer->client_name_ab);

        switch ($customer->status) {

            case 1:
                array_push($customer_array, '取引終了');
                break;
            case 2:
                array_push($customer_array, '本登録中止');
                break;
            case 3:
                array_push($customer_array, '取引中');
                break;
            case 4:
                array_push($customer_array, '仮登録中');
                break;

            default:
                array_push($customer_array, '');
        }

        array_push($customer_array, $customer->corporation_num); // push customer information to array
        array_push($customer_array, $customer->tsr_code);
        array_push($customer_array, $customer->akikura_code);

        if ($customer->client_code_main) {

            array_push($customer_array, $customer->client_code_main);
        } else {

            array_push($customer_array, $customer->client_code);
        }

        array_push($customer_array, $customer->client_address);
        array_push($customer_array, $customer->closing_time);
        array_push($customer_array, $customer->collection_site);

        switch ($customer->sale) {

            case 1:
                array_push($customer_array, '売上先');
                break;
            case 2:
                array_push($customer_array, '仕入先');
                break;
            case 3:
                array_push($customer_array, '売上先/仕入先');
                break;
            default:
                array_push($customer_array, '');
        }

        if ($customer->transferee == true) {

            array_push($customer_array, 'true');
        } else {

            array_push($customer_array, 'false');
        }


        array_push($customer_array, $customer->transferee_name);

        if ($customer->antisocial == true) {

            array_push($customer_array, 'true');
        } else {

            array_push($customer_array, 'false');
        }

        if ($customer->credit == true) {

            array_push($customer_array, 'true');
        } else {

            array_push($customer_array, 'false');
        }

        if ($customer->credit_check()) { // if customer has credit then get all credit's information

            array_push($customer_array, $customer->credit_check()->credit_limit);
            array_push($customer_array, $customer->credit_check()->expiration_date);
            array_push($customer_array, $customer->credit_check()->rank);
            array_push($customer_array, $customer->credit_check()->get_time);
        } else {

            array_push($customer_array, '');
            array_push($customer_array, '');
            array_push($customer_array, '');
            array_push($customer_array, '');
        }


        return $customer_array;
    }


    // 検索するときのcsv作成
    public function getCustomerData($request)
    {

        $list_customers = array();

        if ($this->checkSessionExist($request) == 1) {

            $condition = $this->getSearchCondition($request);

            $customers = $this->search($condition[0], $condition[1], $condition[2], $condition[3], $condition[4], $condition[5]);

            foreach ($customers as $customer) {

                array_push($list_customers, $this->changeFormatData($customer->me_id));
            }
        } else {

            $columns = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
            array_push($list_customers, $columns);
        }

        return $this->getDataForCreateCsv($list_customers);
    }

    // 編集ページのcsv

    public function getOnceCustomerData($client_id)
    {

        $customers = array();
        array_push($customers, $this->changeFormatData($client_id));

        return $this->getDataForCreateCsv($customers);
    }
    // csv　ファイル作成
    public function getDataForCreateCsv($customers)
    {


        $columns = array('顧客名', '顧客名カナ', '略称', 'ステータス', '法人番号', 'TSRコード', '商材コード', '顧客コード', '住所', '決算月日', '回収サイト', '取引区分', '振込人名称相違', '振込人名称', '反射チェック済', '信用調査済', '与信限度額', '与信期間', '格付け情報', '与信情報取得日', '備考');

        echo "\xEF\xBB\xBF";


        $callback = function () use ($columns, $customers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            //fwrite($file, "sep=\t" . "\r\n");
            foreach ($customers as $customer) {


                fputcsv($file, $customer);
            }

            fclose($file);
        };

        return $callback;
    }
    //最新の与信情報のID
    public function getCreditIdlatest()
    {
        // $credit_id  = DB::select('select client_id, max(get_time) as get_time from credit_check group by client_id');
        $credit_id  = DB::select('  select Max(id) as max_id from ( select id, client_id, get_time, max(get_time) over (partition by client_id) as max_get_time from credit_check) t where get_time = max_get_time GROUP BY client_id');
        return $credit_id;
    }

    //最新の与信情報
    public function crediteslatest($company_id)
    {
        $credit_id_data = $this->getCreditIdlatest();
        $credites     = Customer_MST::whereIn('customer_mst.company_id', $company_id)
            ->where('credit_check.rank', '<>', '??')
            ->whereIn('status', [1, 3])
            ->whereIn('credit_check.id', array_column($credit_id_data, 'max_id'))
            ->join('credit_check', 'customer_mst.id', '=', 'credit_check.client_id')
            ->orderBy('expiration_date', 'asc')
            ->orderBy('client_id', 'desc')
            ->select('customer_mst.*', 'credit_expect', 'client_id', 'customer_mst.id as id', 'get_time', 'expiration_date as ex_date', 'rank');

        return $credites;
    }

    //ホーム使用　本務の情報のみ取得
    // public function crediteslatest_only($company_id)
    // {
    //     $credit_id_data = $this->getCreditIdlatest();
    //     $credites     = Customer_MST::where('customer_mst.company_id', $company_id)
    //         ->where('credit_check.rank', '<>', '??')
    //         ->whereIn('status', [1, 3])
    //         ->whereIn('credit_check.id', array_column($credit_id_data, 'max_id'))
    //         ->join('credit_check', 'customer_mst.id', '=', 'credit_check.client_id')
    //         ->select('customer_mst.*', 'credit_expect', 'client_id', 'customer_mst.id as id', 'get_time', 'rank');

    //     return $credites;
    // }

    public function getPrePathInfo()
    {
        if (strpos(url()->previous(), 'customer/edit') !== false) {
            return 1;
        }
        if (strpos(url()->previous(), 'customer/view') !== false) {
            return 2;
        }

        if (strpos(url()->previous(), 'credit/create') !== false) {
            return 3;
        }

        // pre url = index credit
        if (strpos(url()->previous(), 'credit/index') !== false) {
            return 4;
        }

        return 0;
    }
}
