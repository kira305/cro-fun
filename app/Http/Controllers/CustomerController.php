<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Service\CustomerService;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Input;
use App\Rules\CheckUniqueStrCode;
use App\Rules\CheckUniqueCorporationNum;
use App\Rules\CheckClientName;
use App\Rules\CheckClientNameKana;
use App\Repositories\CreditInforRepository;
use App\Customer_infor;
use App\Customer_MST;
use App\Customer_name_MST;
use App\Project_MST;
use App\Credit_check;
use Mail;
use Auth;
use DB;
use Common;
use Javascript;
use Session;
use Crofun;

class CustomerController extends Controller
{

    protected $customer_service;
    protected $creditInforRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customer_service, CreditInforRepository $creditInforRepository)
    {
        //$this->middleware('auth');
        $this->customer_service        = $customer_service;
        $this->creditInforRepository   = $creditInforRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $company_id    = $request->company_id;
            $customer_code = $request->customer_code;
            $customer_name = mb_convert_kana($request->customer_name, 'rhk');
            $personal_code = $request->personal_code;
            $sale          = $request->sale;
            $status        = $request->status;


            session(['company_id_c'     => $company_id]);
            session(['customer_code_c'  => $customer_code]);
            session(['customer_name_c'  => $customer_name]);
            session(['personal_code_c'  => $personal_code]);
            session(['sale'             => $sale]);
            session(['status'           => $status]);

            // $customers = Customer_MST::with('company_name')->get();

            $customers = $this->customer_service->search($company_id, $customer_code, $customer_name, $personal_code, $sale, $status);

            return view('customer.index', ['customers' => $customers]);
        }
        /*
        if (isset($request->client_id)){
          $client_id   =   $request->client_id;
          $customer = Customer_MST::where('id',$client_id)->first();
          session(['company_id_c'     => null]);
          session(['customer_code_c'  => $customer->client_code_main]);
          session(['customer_name_c'  => null]);
          session(['personal_code_c'  => null]);
          session(['sale'             => null]);
          session(['status'           => null]);
        }
*/
        //検索条件存在しているかを確認
        if ($this->customer_service->checkSessionExist($request) == 1) {

            $condition = $this->customer_service->getSearchCondition($request);

            $customers = $this->customer_service->search($condition[0], $condition[1], $condition[2], $condition[3], $condition[4], $condition[5]);

            return view('customer.index', ['customers' => $customers]);
        }

        $company_id_R  =  Auth::user()->company_id;

        $customers = $this->customer_service->search($company_id_R, null, null, null, null, null);
        return view('customer.index', ['customers' => $customers]);
    }

    /*
    * edit customer informatin
    * $request : form data
    * return update customer information status
    */


    public function search(Request $request)
    {

        if ($request->isMethod('post')) {

            $company_id    = $request->company_id;
            $customer_code = $request->customer_code;
            $customer_name = $request->customer_name;
            $personal_code = $request->personal_code;
            $sale          = $request->sale;
            $status        = $request->status;

            session(['company_id_c'     => $company_id]);
            session(['customer_code_c'  => $customer_code]);
            session(['customer_name_c'  => $customer_name]);
            session(['personal_code_c'  => $personal_code]);
            session(['sale'             => $sale]);
            session(['status'           => $status]);

            // $customers = Customer_MST::with('company_name')->get();

            $customers = $this->customer_service->search($company_id, $customer_code, $customer_name, $personal_code, $sale, $status);


            return response()->json(['customers' =>  $customers]);
        }
    }


    public function validationDataInput(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'company_id'            => 'required',
            'client_name'           => [
                'required',
                new CheckClientName($request->company_id, $request->id)
            ],
            'client_name_kana_conversion'      =>
            [
                'required',
                'regex:/^[ｦ-ﾟ\x20]*$/u',
                new CheckClientNameKana($request->company_id, $request->id)
            ],
            //     'client_name_ab'        => 'required',
            //     'status'                => 'required',

            'corporation_num'       => [
                'nullable',
                'max:13',
                'min:13',
                'regex:/^[0-9]*$/u',
                new CheckUniqueCorporationNum($request->company_id, $request->id)
            ],

            'tsr_code'              => [
                'nullable',
                'max:9',
                'min:9',
                'regex:/^[0-9]*$/u',
                new CheckUniqueStrCode($request->company_id, $request->id)
            ],
            //   'akikura_code'          => 'required',
            //   'client_code'           => 'required',
            //   'client_address'        => 'required',
            //   'closing_month'         => 'required',
            'sale'                  => 'required',
            'group_id'              => 'required',

            //   'transferee_name'       => 'required',
            //   'collection_site'       => 'required'
            'credit_expect'         => 'required_if:rank,A,B,C,D,E1,E2,F1,F2'



        ], [

            'company_id.required'         => trans('validation.company_code'),
            'client_name.required'        => trans('validation.client_name'),
            'client_name_kana_conversion.required'  => trans('validation.customer_name_kana'),
            'client_name_kana_conversion.regex'     => trans('validation.client_name_kana_hankaku'),
            'client_name_ab.required'     => trans('validation.client_name_ab'),
            //   'status.required'             => trans('validation.status'),
            'tsr_code.required'           => trans('validation.tsr_code'),
            'tsr_code.min'                => trans('validation.tsr_code_lenght'),
            'tsr_code.max'                => trans('validation.tsr_code_lenght'),
            'tsr_code.regex'              => trans('validation.tsr_code_int'),
            //  'akikura_code.required'       => trans('validation.akikura_code'),
            'client_code.required'        => trans('validation.client_code'),
            'client_address.required'     => trans('validation.client_address'),
            //    'closing_month.required'      => trans('validation.closing_month'),
            //    'collection_site.required'    => trans('validation.collection_site'),
            'corporation_num.max'         => trans('validation.corporation_num_lenght'),
            'corporation_num.min'         => trans('validation.corporation_num_lenght'),
            'corporation_num.regex'       => trans('validation.corporation_num_int'),
            //    'akikura_code.max'            => trans('validation.akikura_code'),
            //    'akikura_code.min'            => trans('validation.akikura_code'),
            //    'akikura_code.regex'          => trans('validation.akikura_code'),
            'sale.required'               => trans('validation.status'),
            'credit_expect.required_if'   => trans('validation.credit_expect'),
            'group_id.required'           => trans('validation.group_id'),


        ]);

        return $validator;
    }

    /*
    * edit customer informatin
    * $request : form data
    * return update customer information status
    */

    public function edit(Request $request)
    {


        DB::beginTransaction();
        session(['client_id'     => $request->id]);
        // //取引想定額
        // $credit_expect = Project_MST::leftjoin('customer_mst','customer_mst.id','=','project_mst.client_id')
        //    ->where('client_id', $request->id)
        //    ->where('project_mst.status','false')
        //    ->sum('transaction_money');
        // //単発
        // $transaction_shot = Project_MST::leftjoin('customer_mst','customer_mst.id','=','project_mst.client_id')
        //    ->where('client_id', $request->id)
        //    ->where('project_mst.status','false')
        //    ->where('project_mst.once_shot','true')
        //    ->sum('transaction_shot');
        $client_id     =  $request->id;
        // $customer      =  $this->customer_service->getCustomerById($client_id);
        // dd($customer->credit_check_by_get_time());
        $transaction =  $this->creditInforRepository->getTransactionMoney($request->id);

        if ($request->isMethod('post')) {

            //カナに変換する
            $client_name_kana_conversion     =  mb_convert_kana($request->client_name_kana, 'rhk');
            $client_name_kana_conversion     =  preg_replace(array("/ /", "/　/"), "", $client_name_kana_conversion);

            $request->merge([
                'client_name_kana_conversion' => $client_name_kana_conversion,
            ]);

            $validator     =  $this->validationDataInput($request); // check form's data rule
            $client_id     =  $request->id;
            $customer      =  $this->customer_service->getCustomerById($client_id); // get customer object by id
            $old_date      = json_encode($customer);
            $old_name      =  $customer->client_name_kana;
            $company_id              = $request->company_id;
            $client_name             = $request->client_name;
            $client_name_ab          = $request->client_name_ab;
            $client_name_kana        = $request->client_name_kana_conversion;
            $corporation_num         = $request->corporation_num;
            $client_address          = $request->client_address;
            $closing_time            = $request->closing_month;
            $tsr_code                = $request->tsr_code;
            $akikura_code            = $request->akikura_code;
            $collection_site         = $request->collection_site;
            $transferee_name         = $request->transferee_name;
            $sale                    = $request->sale;
            $status                  = $request->status;
            $note                    = $request->note;
            // checkbox
            $transferee              = $request->transferee;
            $antisocial              = $request->antisocial;
            $credit                  = $request->credit;
            $request_group           = $request->group_id;

            if ($transferee == 'on') {

                $transferee  = true;
            } else {

                $transferee  = false;
            }

            if ($antisocial == 'on') {

                $antisocial  = true;
            } else {

                $antisocial  = false;
            }

            if ($credit == 'on') {

                $credit  = true;
            } else {

                $credit  = false;
            }


            // credit check
            // $rank                        = $request->rank;
            // $get_time                    = $request->get_time;
            // $credit_limit                = $request->credit_limit;
            // $credit_division             = $request->credit_division;
            if ($request->client_code_main != null) {

                $customer->client_code_main  =  $request->client_code_main;

                $pattern = "/^[0-9]/";

                if (preg_match($pattern, $request->client_code_main)) {
                } else {

                    $validator->errors()->add('client_code_main', trans('validation.client_code_main'));
                }
            }

            $customer->client_name       =  $client_name;
            $customer->client_name_ab    =  $client_name_ab;
            $customer->client_name_kana  =  $client_name_kana;
            $customer->corporation_num   =  $corporation_num;
            $customer->client_address    =  $client_address;
            $customer->closing_time      =  $closing_time;
            $customer->tsr_code          =  $tsr_code;
            $customer->akikura_code      =  $akikura_code;
            $customer->collection_site   =  $collection_site;
            $customer->transferee_name   =  $transferee_name;
            $customer->sale              =  $sale;
            $customer->status            =  $status;
            $customer->note              =  $note;
            $customer->transferee        =  $transferee;
            $customer->antisocial        =  $antisocial;
            $customer->credit            =  $credit;
            $customer->request_group     =  $request_group;


            if ($validator->fails()) {

                $errors = $validator->errors();

                return view('customer.edit', ['customer' => $customer, "errors" => $errors, 'transaction' => $transaction]);
            }

            try {

                if ($customer->update()) {

                    if (!$this->companyNameCompare($client_name_kana, $old_name)) { // check new name and oldname

                        $customer_name                        = new Customer_name_MST(); // customer's name for search
                        $customer_name->id                    = $this->getMaxIdCustomerName()[0]->max + 1;
                        $customer_name->client_id             = $customer->id;
                        $customer_name->client_name_s         = $customer->client_name;
                        $customer_name->client_name_hankaku_s = $customer->client_name_kana;
                        $customer_name->del_flag              = false;
                        $customer_name->save();
                    }
                }
                // if($customer->update()){

                //    $credit_check                  = new Credit_check();
                //    $credit_check->client_id       = $customer->id;
                //    $credit_check->company_id      = $company_id;
                //    $credit_check->rank            = $rank;
                //    $credit_check->get_time        = $get_time;
                //    $credit_check->credit_limit    = $credit_limit;
                //    $credit_check->credit_division = $credit_division;

                //    $credit_check->save();
                // }

                if ($customer->client_code_main != null) {

                    $code  =  $customer->client_code_main;
                } else {
                    $code  =  $customer->client_code;
                }
                Crofun::log_create(Auth::user()->id, $customer->id, config('constant.CLIENT'), config('constant.operation_UPDATE'), config('constant.CLIENT_EDIT'), $customer->company_id, $customer->client_name, $code, json_encode($customer), $old_date);

                DB::commit(); // if not exist exception then commit all transaction
                Session::flash('message', trans('message.update_success'));

                return view('customer.edit', ['customer' => $customer, 'transaction' => $transaction]);
            } catch (Exception $e) {

                DB::rollBack();
                throw new Exception($e);
            }
        }

        $customer_id =  $request->id;
        $customer    =  $this->customer_service->getCustomerById($customer_id);

        return view('customer.edit', ['customer' => $customer, 'transaction' => $transaction]);
    }

    public function view(Request $request)
    {

        $customer_id =  $request->id;
        $customer    =  $this->customer_service->getCustomerById($customer_id);

        // $credit_expect = Project_MST::leftjoin('customer_mst','customer_mst.id','=','project_mst.client_id')
        //  ->where('client_id', $request->id)
        //  ->where('project_mst.status','false')
        //  ->sum('transaction_money');
        //  //単発
        // $transaction_shot = Project_MST::leftjoin('customer_mst','customer_mst.id','=','project_mst.client_id')
        //    ->where('client_id', $request->id)
        //    ->where('project_mst.status','false')
        //    ->where('project_mst.once_shot','true')
        //    ->sum('transaction_shot');

        //  $transaction =  $credit_expect + $transaction_shot;
        $transaction =  $this->creditInforRepository->getTransactionMoney($request->id);
        return view('customer.view', ['customer' => $customer, 'transaction' => $transaction]);
    }

    /*
    * compare newname and oldname , if different then return false if not different return true
    * $new_name form's value
    * $old_name value get from database
    */
    public function companyNameCompare($new_name, $old_name)
    {

        if (strcmp(trim($new_name), trim($old_name)) == 0) {

            return true;
        } else {

            return false;
        }
    }

    /*
    * create new customer' information
    * $new_name form's value
    * $old_name value get from database
    */

    public function create(Request $request, $id = null)
    {



        if ($request->isMethod('post')) {

            //カナに変換する
            $client_name_kana_conversion     =  mb_convert_kana($request->client_name_kana, 'rhk');
            $client_name_kana_conversion     =  preg_replace(array("/ /", "/　/"), "", $client_name_kana_conversion);

            $rank_conversion             = $this->customer_service->credit_rank($request->rank);
            $renew_time                  = $this->customer_service->getRenewTimeRM(
                $request->get_time,
                $request->rank,
                $request->credit_expect,
                $request->credit_limit
            );
            $credit_limit               = mb_convert_kana($request->credit_limit, 'rn');
            $credit_limit               = (int)filter_var($credit_limit, FILTER_SANITIZE_NUMBER_INT);

            $request->merge([
                'client_name_kana_conversion' => $client_name_kana_conversion,
                'rank_conversion' => $rank_conversion,
                'renew_time_conversion' => $renew_time,
                'credit_limit' => $credit_limit
            ]);
            try {

                session()->flashInput($request->input());
                $validator     =  $this->validationDataInput($request);

                if ($validator->fails()) {

                    $errors = $validator->errors();

                    return view('customer.create', ["errors" => $errors]);
                }

                $company_id              = $request->company_id;
                $client_code             = $request->client_code;
                $client_name             = $request->client_name;
                $client_name_ab          = $request->client_name_ab;
                $client_name_kana        = $request->client_name_kana_conversion;
                $corporation_num         = $request->corporation_num;
                $client_address          = $request->client_address;
                $closing_time            = $request->closing_month;
                $tsr_code                = $request->tsr_code;
                $akikura_code            = $request->akikura_code;
                $collection_site         = $request->collection_site;
                $transferee_name         = $request->transferee_name;
                $sale                    = $request->sale;
                $status                  = $request->status;
                $note                    = $request->note;
                // checkbox
                $transferee              = $request->transferee;
                $antisocial              = $request->antisocial;
                $credit                  = $request->credit;
                $request_group           = $request->group_id;

                if ($transferee == 'on') {

                    $transferee  = true;
                } else {

                    $transferee  = false;
                }

                if ($antisocial == 'on') {

                    $antisocial  = true;
                } else {

                    $antisocial  = false;
                }

                if ($credit == 'on') {

                    $credit  = true;
                } else {

                    $credit  = false;
                }



                DB::beginTransaction();

                $customer                    = new Customer_MST(); // create new object
                $customer->id                =  $this->getMaxId()[0]->max + 1;
                $customer->company_id        =  $company_id;
                $customer->client_code       =  $client_code;
                $customer->client_name       =  $client_name;
                $customer->client_name_ab    =  $client_name_ab;
                $customer->client_name_kana  =  $client_name_kana;
                $customer->corporation_num   =  $corporation_num;
                $customer->client_address    =  $client_address;
                $customer->closing_time      =  $closing_time;
                $customer->tsr_code          =  $tsr_code;
                $customer->akikura_code      =  $akikura_code;
                $customer->collection_site   =  $collection_site;
                $customer->transferee_name   =  $transferee_name;
                $customer->sale              =  $sale;
                $customer->status            =  $status;
                $customer->note              =  $note;

                $customer->transferee        =  $transferee;
                $customer->antisocial        =  $antisocial;
                $customer->credit            =  $credit;
                $customer->request_group     =  $request_group;

                $customer->save();

                $credit_limit                  = $request->credit_limit;
                $rank                          = $request->rank;
                $get_time                      = $request->get_time;
                $credit_expect                 = $request->credit_expect;

                if ($request->check_credit == 1) { // if is existed credit data then save to database
                    if ($request->rank == 'G') {

                        $credit_check                  = new Credit_check();
                        $credit_check->id              = $this->getMaxIdCredit()[0]->max + 1;
                        $credit_check->client_id       = $customer->id;
                        $credit_check->company_id      = $company_id;
                        $credit_check->get_time        = $get_time;
                        $credit_check->credit_limit    = $credit_limit;
                        $credit_check->rank            = $rank_conversion;
                        $credit_check->credit_division = $sale;
                        $credit_check->save();
                    } else {

                        $credit_check                  = new Credit_check();
                        $credit_check->id              = $this->getMaxIdCredit()[0]->max + 1; // get max id of table
                        $credit_check->client_id       = $customer->id;
                        $credit_check->company_id      = $company_id;
                        $credit_check->get_time        = $get_time;

                        if ($credit_limit != "") {

                            $credit_check->credit_limit    = $credit_limit * 1000;
                        } else {

                            $credit_check->credit_limit    = 0;
                        }

                        $credit_check->rank            = $rank_conversion;
                        $credit_check->credit_division = $sale;
                        $credit_check->expiration_date = $renew_time;
                        $credit_check->credit_expect   = $credit_expect * 1000;

                        Crofun::log_create(Auth::user()->id, $credit_check->id, config('constant.CREDIT'), config('constant.operation_CRATE'), config('constant.CLIENT_ADD'), $credit_check->company_id, $customer->client_name, $customer->client_code, json_encode($credit_check), null);
                        $credit_check->save();
                    }
                }


                $customer_name                        = new Customer_name_MST();
                $customer_name->id                    = $this->getMaxIdCustomerName()[0]->max + 1;
                $customer_name->client_id             = $customer->id;
                $customer_name->client_name_s         = $customer->client_name;
                $customer_name->client_name_hankaku_s = $customer->client_name_kana;
                $customer_name->del_flag              = false;
                $customer_name->save();

                Crofun::log_create(Auth::user()->id, $customer->id, config('constant.CLIENT'), config('constant.operation_CRATE'), config('constant.CLIENT_ADD'), $customer->company_id, $customer->client_name, $customer->client_code, json_encode($customer), null);

                DB::commit();

                return back()->with('message', trans('message.save_success'));
            } catch (Exception $e) {

                DB::rollBack();
                throw new Exception($e);
            }
        }


        return view('customer.create');
    }
    // upload customer's file information
    /*
    * リスモンからのcsvファイルをアップロード
    * $new_name form's value
    * return ファイルの内容を取得してデータベースに蓄積
    */
    public function upload(Request $request)
    {

        $usr_id         = Auth::user()->id;
        $customer_infor = new Customer_infor();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [

                'csv'                  => 'required|mimes:csv,txt',
                'credit_expect'        => 'required|regex:/^[0-9]*$/u'

            ], [

                'csv.required'               => trans('validation.company_name'),
                'csv.mimes'                  => trans('validation.file_upload_fomat'),
                'credit_expect.required'     => trans('validation.credit_expect'),
                'credit_expect.regex'        => trans('validation.credit_expect_format')

            ]);

            if ($validator->fails()) { // if has errors the return code 302

                $errors = $validator->errors();

                if ($errors->has('csv')) {

                    return response()->json([

                        'status'   => 302,
                        'errors'   => $errors

                    ]);
                }

                if ($errors->has('credit_expect')) {

                    return response()->json([

                        'status'   => 300,
                        'errors'   => $errors

                    ]);
                }
            }

            try {

                $csv = Input::file('csv');
                $credit_expect = $request->credit_expect;
                Storage::disk('public')->put($csv->getClientOriginalName(),  File::get($csv));
                // save file wa uloaded to public disk
                $csv_url = public_path() . '/uploads/' . $csv->getClientOriginalName();
                mb_language("Japanese");
                $row = 0;
                $customer                     = new Customer_MST(); // create new customer object

                if (($handle = fopen($csv_url, "r")) !== FALSE) {

                    while (($data = fgetcsv($handle)) !== FALSE) { // if data is not end row

                        if ($row >= 1) {

                            $client_name        = mb_convert_encoding($data[0], 'UTF-8', 'ASCII, JIS, UTF-8, SJIS');
                            $tsr_code           = $data[1];
                            $client_address     = mb_convert_encoding($data[2], 'UTF-8', 'ASCII, JIS, UTF-8, SJIS');
                            $tel                = $data[4];
                            $corporation_num    = mb_convert_encoding($data[74], 'UTF-8', 'ASCII, JIS, UTF-8, SJIS');
                            $closing_month      = mb_convert_encoding($data[17], 'UTF-8', 'ASCII, JIS, UTF-8, SJIS');
                            $get_time           = $data[12];
                            $rank               = $data[13];
                            $credit_limit       = $data[21];

                            $customer->client_name        =  $client_name;
                            $customer->tsr_code           =  $tsr_code;
                            $customer->client_address     =  $client_address;
                            $customer->corporation_num    =  $corporation_num;
                            $customer->closing_month      =  $closing_month;
                            $customer->get_time           =  $get_time;
                            $customer->rank               =  $rank;
                            $customer->credit_limit       =  $credit_limit;

                            $expiration_date              =  $this->customer_service->getRenewTimeRM(
                                $get_time,
                                $rank,
                                $credit_expect,
                                $credit_limit
                            );
                        }

                        $row++;
                    }

                    fclose($handle);
                }


                unlink($csv_url); //delete file uploaded

                return response()->json(['csv' =>  $customer, 'expiration_date' =>  $expiration_date]);
            } catch (Exception $e) {

                throw new Exception($e);
            }
        }
    }
    // dowload csv from search screen
    /*
    * create csv file at search screen
    * $request :search condition had been saved in session
    * return sream dowload
    */
    public function getCsv1(Request $request)
    {

        try {

            $file_name = '顧客情報_' . Common::getToDayCSV();
            $callback  = $this->customer_service->getCustomerData($request); // call get customer data function from service
            $headers   = array(
                "Content-sale" => "text/csv",
                "Content-Disposition" => "attachment; filename=" . $file_name . '.csv',
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );
        } catch (Exception $e) {

            throw new Exception($e);
        }
        return response()->stream($callback, 200, $headers);
    }
    // dowload csv from update information screen

    /*
    * create csv file at update screen
    * $request: customer's id
    * return sream dowload
    */
    public function getCsv2(Request $request)
    {

        try {
            $client_id = $request->client_id;
            $file_name = '顧客情報_' . $this->getCustomerName($client_id) . '_' . Common::getToDayCSV();

            $callback  = $this->customer_service->getOnceCustomerData($client_id);
            // call get customer's strem data from service
            $headers   = array(
                "Content-sale" => "text/csv",
                "Content-Disposition" => "attachment; filename=" . $file_name . '.csv',
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );
        } catch (Exception $e) {

            throw new Exception($e); // if has exception then break and handout

        }
        return response()->stream($callback, 200, $headers);
    }

    // get max id from table
    public function getMaxId()
    {

        $id  = DB::select('select MAX(id) from customer_mst');

        return $id;
    }

    public function getMaxIdCustomerName()
    {

        $id  = DB::select('select MAX(id) from customer_name');

        return $id;
    }

    public function getMaxIdCredit()
    {

        $id  = DB::select('select MAX(id) from credit_check');

        return $id;
    }


    public function getCustomerName($id)
    {

        $customer = Customer_MST::where('id', $id)->first();

        return $customer->client_name_ab;
    }

    // get customer code by ajax
    public function getCustomerCode(Request $request)
    {

        $company_id = $request->company_id;
        $num        =  Crofun::customer_number_create($company_id);
        return response()->json(['num' =>  $num]);
    }

    public function changeCode(Request $request)
    {

        $company_id = $request->company_id;
        $num =  Crofun::customer_number_create_main($company_id);
        return response()->json(['num' =>  $num]);
    }

    public function checkProjectNotEnd(Request $request)
    {

        $customer_id = $request->customer_id;
        $status      = Crofun::checkProjectIsEnd($customer_id);
        return response()->json(
            [
                'status'  => $status,
                'message' => trans('message.customer_close')

            ]
        );
    }

    public function checkCustomerIsEnd(Request $request)
    {

        $status = 0;
        $customer_id = $request->customer_id;
        $customer    = Customer_MST::where('id', $customer_id)->first();

        if ($customer->status == 4) {

            $status = 1;
        }

        return response()->json(
            [
                'status'  => $status,
                'message' => trans('message.project_close')

            ]
        );
    }
}
