<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Service\UserServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Customer_MST;
use App\Project_MST;
use App\Contract_MST;
use App\Rule_action;
use App\Menu;
use Auth;
use Response;
use Excel;
use Helper;
use Exception;
use DB;
use App\Events\Event;
use App\Events\LogEvent;
use Crofun;
class ContractController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
       
    }
    
 //   public function index(){
       
            
   //      $receivable = Receivable_MST::all();
    
     //    return view('receivable.index',["receivable" => $receivable]);
    

   // }
    public function index(Request $request){

    
     //リクエストが与えられたか？ 
      if ($request->isMethod('post')) {

          //画面からリクエストされている情報
          $company_id       = $request->company_id;
          $headquarter_id   = $request->headquarter_id;
          $department_id    = $request->department_id;
          $group_id         = $request->group_id;
          $client_code      = $request->client_code;
          $client_name_kana = mb_convert_kana($request->client_name_kana, 'rhk');
          $corporation_num  = $request->corporation_num;
          $project_code     = $request->project_code;
          $project_name     = $request->project_name;
          $created_at_st   = $request->created_at_st;
          $created_at_en   = $request->created_at_en;

            session(['company_id_cont'       => $company_id]);
            session(['headquarter_id_cont'   => $headquarter_id]);
            session(['department_id_cont'    => $department_id]);
            session(['group_id_cont'         => $group_id]);
            session(['client_code_cont'      => $client_code]);
            session(['client_name_kana_cont' => $client_name_kana]);
            session(['project_code_cont'     => $project_code]);
            session(['project_name_cont'     => $project_name]);
            session(['corporation_num_cont'  => $corporation_num]);
            session(['created_at_st_cont'   => $created_at_st]);
            session(['created_at_en_cont'   => $created_at_en]);


          $validator = $this->validateData($request);
          if ($validator->fails()) {
           
           $company_id_R  =  Auth::user()->company_id;
           $contract = Contract_MST::leftjoin('customer_mst','customer_mst.id','=','contract.client_id')
                                     ->where('contract.company_id',$company_id_R)
                                     ->orderBy('customer_mst.client_code', 'asc')
                                     ->orderBy('contract.created_at', 'desc')
                                     ->select('contract.*')
                                     ->get();

          $errors = $validator->errors();

          return view('contract.index',["errors" => $errors,
                                          "contract"       =>$contract,
                                          "company_id"       =>session('company_id_cont'),
                                          "headquarter_id"   =>session('headquarter_id_cont'),
                                          "department_id"    =>session('department_id_cont'),
                                          "group_id"         =>session('group_id_cont'),
                                          "client_code"      =>session('client_code_cont'),
                                          "client_name_kana" =>session('client_name_kana_cont'), 
                                          "corporation_num"  =>session('corporation_num_cont'),
                                          "project_code"     =>session('project_code_cont'),
                                          "project_name"     =>session('project_name_cont'),
                                          "created_at_st"    =>session('created_at_st_cont'),
                                          "created_at_en"    =>session('created_at_en_cont')
                                      ]);
           
          }
          

          $contract          = $this->search($company_id,$headquarter_id,$department_id,$group_id,$client_code,$client_name_kana,$project_code,$project_name,$corporation_num,$created_at_st,$created_at_en);

          return view('contract.index',[
                                          "contract"       =>$contract,
                                          "company_id"       =>session('company_id_cont'),
                                          "headquarter_id"   =>session('headquarter_id_cont'),
                                          "department_id"    =>session('department_id_cont'),
                                          "group_id"         =>session('group_id_cont'),
                                          "client_code"      =>session('client_code_cont'),
                                          "client_name_kana" =>session('client_name_kana_cont'), 
                                          "corporation_num"  =>session('corporation_num_cont'),
                                          "project_code"     =>session('project_code_cont'),
                                          "project_name"     =>session('project_name_cont'),
                                          "created_at_st"   =>session('created_at_st_cont'),
                                          "created_at_en"   =>session('created_at_en_cont')
                                      ]);

      }
        if (isset($request->client_id)){
          $client_id   =   $request->client_id;
          $customer    = Customer_MST::where('id',$client_id)->first();
          session(['client_code_cont'       => $customer->client_code_main != null ? $customer->client_code_main : $customer->client_code]);
          session(['company_id_cont'        => $customer->company_id]);
          session(['headquarter_id_cont'    => null]);
          session(['department_id_cont'     => null]);
          session(['group_id_cont'          => null]);
          session(['client_name_kana_cont'  => null]);
          session(['corporation_num_cont'   => null]);
          session(['project_name_cont'      => null]);
          session(['created_at_st_cont'     => null]);
          session(['created_at_en_cont'     => null]);
          session(['project_code_cont'      => null]);
        }
        if(isset($request->project_id)){
          $project_id  =   $request->project_id;
          $project     = Project_MST::where('id',$project_id)->first();
          session(['project_code_cont'      => $project->project_code]);
          session(['company_id_cont'        => $project->company_id]);
          session(['headquarter_id_cont'    => null]);
          session(['department_id_cont'     => null]);
          session(['group_id_cont'          => null]);
          session(['client_name_kana_cont'  => null]);
          session(['corporation_num_cont'   => null]);
          session(['project_name_cont'      => null]);
          session(['created_at_st_cont'     => null]);
          session(['created_at_en_cont'     => null]);
          session(['client_code_cont'       => null]);
      
        }

    //セッションの情報で検索　(他の画面から遷移した時)
      if(
          $request->session()->exists('company_id_cont')       ||
          $request->session()->exists('headquarter_id_cont')   ||
          $request->session()->exists('department_id_cont')    ||
          $request->session()->exists('group_id_cont')         ||
          $request->session()->exists('client_code_cont')      ||
          $request->session()->exists('client_name_kana_cont') ||
          $request->session()->exists('corporation_num_cont')  ||
          $request->session()->exists('project_code_cont')     ||
          $request->session()->exists('project_name_cont')     ||
          $request->session()->exists('created_at_st_cont')   ||
          $request->session()->exists('created_at_en_cont')     

         ){

          $validator = $this->validateData($request);
          if ($validator->fails()) {

           $company_id_R  =  Auth::user()->company_id;

           $contract = Contract_MST::leftjoin('customer_mst','customer_mst.id','=','contract.client_id')
                                     ->where('contract.company_id',$company_id_R)
                                     ->orderBy('customer_mst.client_code', 'asc')
                                     ->orderBy('contract.created_at', 'desc')
                                     ->select('contract.*')
                                     ->paginate(20);

          $errors = $validator->errors();

          return view('contract.index',["errors" => $errors,
                                          "contract"       =>$contract,
                                          "company_id"       =>session('company_id_cont'),
                                          "headquarter_id"   =>session('headquarter_id_cont'),
                                          "department_id"    =>session('department_id_cont'),
                                          "group_id"         =>session('group_id_cont'),
                                          "client_code"      =>session('client_code_cont'),
                                          "client_name_kana" =>session('client_name_kana_cont'), 
                                          "corporation_num"  =>session('corporation_num_cont'),
                                          "project_code"     =>session('project_code_cont'),
                                          "project_name"     =>session('project_name_cont'),
                                          "created_at_st"   =>session('created_at_st_cont'),
                                          "created_at_en"   =>session('created_at_en_cont')
                                      ]);
           
          }   

          $condition = $this->searchCostBySession($request);
          $contract = $this->search($condition[0],$condition[1],$condition[2],$condition[3],$condition[4],$condition[5],$condition[6],$condition[7],$condition[8],$condition[9],$condition[10]);
     
              return view('contract.index',[
                                          "contract"       =>$contract,
                                          "company_id"       =>session('company_id_cont'),
                                          "headquarter_id"   =>session('headquarter_id_cont'),
                                          "department_id"    =>session('department_id_cont'),
                                          "group_id"         =>session('group_id_cont'),
                                          "client_code"      =>session('client_code_cont'),
                                          "client_name_kana" =>session('client_name_kana_cont'), 
                                          "corporation_num"  =>session('corporation_num_cont'),
                                          "project_code"     =>session('project_code_cont'),
                                          "project_name"     =>session('project_name_cont'),
                                          "created_at_st"   =>session('created_at_st_cont'),
                                          "created_at_en"   =>session('created_at_en_cont')
                                      ]);
            
      }

      if(
          $request->session()->exists('company_id_cont')       ||
          $request->session()->exists('client_code_cont')      ||
          $request->session()->exists('project_code_cont')     
         ){          

            $contract = $this->search($condition[0],$condition[1],$condition[2],$condition[3],$condition[4],$condition[5],$condition[6],$condition[7],$condition[8],$condition[9],$condition[10]);

              return view('contract.index',[
                                          "contract"       =>$contract,
                                          "company_id"       =>session('company_id_cont'),
                                          "headquarter_id"   =>session('headquarter_id_cont'),
                                          "department_id"    =>session('department_id_cont'),
                                          "group_id"         =>session('group_id_cont'),
                                          "client_code"      =>session('client_code_cont'),
                                          "client_name_kana" =>session('client_name_kana_cont'), 
                                          "corporation_num"  =>session('corporation_num_cont'),
                                          "project_code"     =>session('project_code_cont'),
                                          "project_name"     =>session('project_name_cont'),
                                          "created_at_st"   =>session('created_at_st_cont'),
                                          "created_at_en"   =>session('created_at_en_cont')
                                      ]);
            }



      $company_id_R  =  Auth::user()->company_id;
     
      $contract = Contract_MST::leftjoin('customer_mst','customer_mst.id','=','contract.client_id')
                              ->where('contract.company_id',$company_id_R)
                              ->orderBy('customer_mst.client_code', 'asc')
                               ->orderBy('contract.created_at', 'desc')
                               ->select('contract.*')
                               ->paginate(20);

      return view('contract.index',['contract' => $contract]);

    }


    public function searchCostBySession($request){

        $condition = array();
        if ($request->session()->exists('company_id_cont')) {
          
             $company_id = session('company_id_cont');
             array_push($condition,$company_id);
              
        }else{

              $company_id = "";
              array_push($condition,$company_id);
        }


        if ($request->session()->exists('headquarter_id_cont')) {
               
             $headquarter_id = session('headquarter_id_cont');
             array_push($condition,$headquarter_id);
              
        }else{

              $headquarter_id = "";
              array_push($condition,$headquarter_id);
        }


        if ($request->session()->exists('department_id_cont')) {
               
             $department_id = session('department_id_cont');
             array_push($condition,$department_id);
              
        }else{

              $department_id = "";
              array_push($condition,$department_id);
        }

        if ($request->session()->exists('group_id_cont')) {
               
              $group_id = session('group_id_cont');
              array_push($condition,$group_id);
              
        }else{

              $group_id = "";
              array_push($condition,$group_id);
        }

        if ($request->session()->exists('client_code_cont')) {
               
              $client_code = session('client_code_cont');
              array_push($condition,$client_code);
              
        }else{

              $client_code = "";
              array_push($condition,$client_code);
        }
        
        if ($request->session()->exists('client_name_kana_cont')) {
               
              $client_name_kana  = session('client_name_kana_cont');
              array_push($condition,$client_name_kana);
              
        }else{

              $client_name_kana  = "";
              array_push($condition,$client_name_kana);
        }

        if ($request->session()->exists('project_code_cont')) {
               
              $project_code  = session('project_code_cont');
              array_push($condition,$project_code);
              
        }else{

              $project_code  = "";
              array_push($condition,$project_code);
        }
        
        if ($request->session()->exists('project_name_cont')) {
               
              $project_name  = session('project_name_cont');
              array_push($condition,$project_name);
              
        }else{

              $project_name  = "";
              array_push($condition,$project_name);
        }
        
        if ($request->session()->exists('corporation_num_cont')) {
               
              $corporation_num  = session('corporation_num_cont');
              array_push($condition,$corporation_num);
              
        }else{

              $corporation_num  = "";
              array_push($condition,$corporation_num);
        }

        if ($request->session()->exists('created_at_st_cont')) {
               
              $created_at_st  = session('created_at_st_cont');
              array_push($condition,$created_at_st);
              
        }else{

              $created_at_st  = "";
              array_push($condition,$created_at_st);
        }

          
        if ($request->session()->exists('created_at_en_cont')) {
               
              $created_at_en  = session('created_at_en_cont');
              array_push($condition,$created_at_en);
              
        }else{

              $created_at_en  = "";
              array_push($condition,$created_at_en);
        }
 
      return  $condition;

    }

    public function search($company_id,$headquarter_id,$department_id,$group_id,$client_code,$client_name_kana,$project_code,$project_name,$corporation_num,$created_at_st,$created_at_en){



      //大元の検索条件
      $contract = Contract_MST::leftjoin('customer_mst','customer_mst.id','=','contract.client_id')
                               ->leftjoin('project_mst','project_mst.id','=','contract.project_id')
                               ->orderBy('customer_mst.client_code', 'asc')
                               ->orderBy('contract.created_at', 'desc')
                               ->select('contract.*')
                               ->when($client_code != "", function ($query) use ($client_code) {

                                   return $query->where('customer_mst.client_code',$client_code)->orwhere('customer_mst.client_code_main', $client_code);

                               });
            //検索の条件が有れば、条件をｾｯﾄする
            if($company_id != ""){
                    
                $contract = $contract->where('contract.company_id',$company_id);

             }

            if($headquarter_id != ""){
                    
                $contract = $contract->where('project_mst.headquarter_id',$headquarter_id);

             }

            if($department_id != ""){
                    
                $contract = $contract->where('project_mst.department_id',$department_id);

             }

            if($group_id != ""){
                    
                $contract = $contract->where('project_mst.group_id',$group_id);

             }
             
            // if($client_code != ""){
                            
            //     $contract = $contract->where('customer_mst.client_code',$client_code)->orwhere('customer_mst.client_code_main',$client_code);

            //  }   

            if($project_name != ""){
                    
                $contract = $contract->where('project_mst.project_name','like',"$project_name%");

             }

            if($project_code != ""){
                    
                $contract = $contract->where('project_mst.project_code','like',"$project_code");

             }

             if($client_name_kana != ""){

                $contract = $contract->where('customer_mst.client_name_kana','like',"$client_name_kana%");

             } 

             if($corporation_num != ""){
                    
                $contract = $contract->where('customer_mst.corporation_num',$corporation_num);

             }

             if($created_at_st != "" & $created_at_en != ""  ){

                $contract = $contract->whereBetween('contract.created_at',[$created_at_st , $created_at_en ]);

             } elseif($created_at_st == "" & $created_at_en != ""  ){

                $contract = $contract->whereBetween('contract.created_at',["2000/01/01", $created_at_en]);


             } elseif($created_at_st != "" & $created_at_en == ""  ){

                $contract = $contract->whereBetween('contract.created_at',[$created_at_st , '9999/12/31']);

             }
                    
             //検索結果
             $contract          = $contract->paginate(20);

             return $contract;

    }
    public function validateData(Request $request){
        /*エラーのチェック 日付型*/
                $validator = Validator::make($request->all(),[

                    'created_at_st'        => 'nullable|date_format:Y/m/d',
                    'created_at_en'        => 'nullable|date_format:Y/m/d',

                ],[

                    'created_at_st.date_format'   => trans('validation.import_log_start_time'),
                    'created_at_en.date_format'   => trans('validation.import_log_end_time'),

                ]);

                $errors = $validator->errors();


              return $validator;


    }

    // pdf表す画面を表示
    public function display(Request $request){
         
         $contract = Contract_MST::where('id',$request->id)->first();
         $this->authorize('display', $contract);
         $file_id = $request->id;
         
         Crofun::log_create(Auth::user()->id,$request->id,config('constant.CONTRACT'),config('constant.operation_REFERENCE'),config('constant.CONTRACT_DISPLAY'),$contract->company_id,$contract->save_ol_name,$contract->id,null,null);

        
         return view('contract.display',['contract' => $file_id]);

    }
    
    // pdfファイルの内容
    public function view(Request $request){
         
         $contract_id = $request->id;

         $contract    = Contract_MST::where('id',$contract_id)->first();

         $file_path   = storage_path('app/private') . '/uploads/'.$contract->save_sv_name;

         return response()->file($file_path);
    }

}
