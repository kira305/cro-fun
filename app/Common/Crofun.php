<?php
namespace App\Common;
use DB;
use Auth;
use App\Log;
use App\Customer_MST;
use App\Company_MST;
use App\Headquarters_MST;
use App\Department_MST;
use App\Group_MST;
use App\Position_MST;
use App\Project_MST;
use App\Concurrently;
use App\Diagram;
use App\Cost_MST;
use Carbon\Carbon;
use App\system;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Input;

class Crofun {
    
    public function getMaxTimeInOr(){

        $created_at  = DB::select("select max(created_at) as created_at from organization_history where flag = true ");
        return $created_at;
    }
    
    public function getTimeForDiagram(){

        // list($usec, $sec) = explode(' ', microtime());
        // $dt = new DateTime(date('Y-m-d\TH:i:s', $sec) . substr($usec, 1));  
        // return $dt->format('Y-m-d H:i:s.u');
        list($usec, $sec) = explode(' ', microtime());
        $dt = new DateTime(date('Y-m-d\TH:i:s', $sec) . substr($usec, 1));  
        $dt  = date_sub($dt, date_interval_create_from_date_string('1 days'));
        return $dt->format('Y-m-d H:i:s.u');
    }

    public function changeFormatDateOfCredit($time){

        $time     = Carbon::parse($time);
        $year     = $time->year;
        $month    = $time->month;
        $day      = $time->day;
        return $year.'年'.$month.'月'.$day.'日';
  
    }

    public function changeFormatDateyymmdd($time){
        
        $time     = Carbon::parse($time);
        $year     = $time->year;
        $month    = $time->month;
        $day      = $time->day;
        return sprintf("%04d",$year).sprintf("%02d",$month).sprintf("%02d",$day);
  
    }

    public function Url_explain(){
         
        $url = str_replace("http://localhost:8000/", '', (string)url()->previous());
        // $url = str_replace('https://cro-fun.noc-net.co.jp/', '', (string)url()->previous());
         //$url = str_replace('https://cro-fun.noc-net.local/', '', (string)url()->previous());
         return $url;
    }
    
    public function project_index_return_button(){


         if($this->Url_explain() === "credit/index"){
           
             return 4;

         }

         if($this->Url_explain() != "home" && $this->Url_explain() != "project/index" && (strpos($this->Url_explain(), 'project/view') !== 0) && (strpos($this->Url_explain(), 'project/edit') !== 0 )){

            if(strpos($this->Url_explain(), 'credit/index') === false){
              
                if(strpos($this->Url_explain(), 'customer/edit') !== false){
                  
                     return 1;
                }

                if(strpos($this->Url_explain(), 'customer/view') !== false){

                    return 3;
                }
    
               
                return 0;

             }else {
                
                return 2;

             }

         }
         
         return 0;
    }
    


    public function credit_index_return_button(){
        


        // return $this->Url_explain();
        if($this->Url_explain() != "home" && $this->Url_explain() != "credit/index" && strpos($this->Url_explain(), 'customer/edit') !== false && request()->client_id != null){

             return 1;
         }

         if(strpos($this->Url_explain(), 'project/index') !== false && request()->client_id != null){

              return 1;
         }
         
         if(strpos($this->Url_explain(), 'customer/view') !== false){

            return 2;

         }
         
         return 0;

    }
    
    public function contract_index_return_button(){
        

        if(strpos($this->Url_explain(), 'project/edit') !== false){

            return 3;
        }
        
        if(strpos($this->Url_explain(), 'project/view') !== false){

            return 4;
        }

   
        if($this->Url_explain() != "home" && $this->Url_explain() != "contract/index" && request()->client_id != null && strpos($this->Url_explain(), 'customer/edit') !== false){

             return 1;
         }

        if(strpos($this->Url_explain(), 'customer/view') !== false){
            
             return 2;
        }

         return 0;
        

    }

    public function receivable_index_return_button(){
         
   
        if($this->Url_explain() != "home" && $this->Url_explain() != "receivable/index" && request()->client_id != null && strpos($this->Url_explain(), 'customer/edit') !== false){

             return 1;
         }
        
        if(strpos($this->Url_explain(), 'customer/view') !== false){
            
             return 2;
        }

         return 0;

    }

    public function process_index_return_button(){
         
        if(strpos($this->Url_explain(), 'project/edit') !== false){

            return 3;
        }
        
        if(strpos($this->Url_explain(), 'project/view') !== false){

            return 4;
        }
        

        if($this->Url_explain() != "home" && $this->Url_explain() != "process/index" && request()->client_id != null && strpos($this->Url_explain(), 'customer/edit') !== false){

             return 1;
         }
         
        if(strpos($this->Url_explain(), 'customer/view') !== false){
            
             return 2;
        }

         return 0;

    }

    public function credit_log_return_button(){
         
   
        if($this->Url_explain() != "home" && $this->Url_explain() != "credit/log" && request()->client_id != null && strpos($this->Url_explain(), 'customer/edit') !== false){

             return 1;
        }
         
        if(strpos($this->Url_explain(), 'customer/view') !== false){
            
             return 2;
        }
        
        if(strpos($this->Url_explain(), 'credit/edit') !== false){
            
             return 3;
        }


         return 0;

    }
    
    public function customer_edit_return_button(){
      
        if(strpos($this->Url_explain(), 'credit/index') !== false){
            
             return 1;
        }

         return 0;

    }
   

   public function credit_create_return_button(){
       
        if(strpos($this->Url_explain(), 'customer/edit') !== false){
          
             return 1;
        }
        if(strpos($this->Url_explain(), 'customer/view') !== false){
            
             return 2;
        }

         return 0;

   }
   
   public function checkProjectIsEnd($customer_id){

           $project = Project_MST::where('status',true)->where('client_id',$customer_id)->first();

           if($project){

               return 1;
           }

           return 2;
   }

   public static function stripXSS()
    {
        $sanitized = static::cleanArray(Input::get());
        Input::merge($sanitized);
    }
    
    public static function cleanArray($array)
    {
        $result = array();
        foreach ($array as $key => $value) {
            $key = strip_tags($key);
            if (is_array($value)) {
                $result[$key] = static::cleanArray($value);
            } else {
                $result[$key] = trim(strip_tags($value)); // Remove trim() if you want to.
            }
       }
       return $result;
    }

    public function getCompanyById($company_id){
       
        $company = Company_MST::where('id',$company_id)->first();

        return $company;
           
    }

    public function getClientById($id){

         $customer = Customer_MST::where('id',$id)->first();

         return $customer;
    }

    // create new client's code
    public function customer_number_create($company_id){
          
        $code  = DB::select('select MAX(client_code) from customer_mst where  company_id = ' .$company_id );

        $code  = $code[0]->max;

        $int   = substr($code,1);

        $int   = $int + 1;

        $code  = 'K'.sprintf("%06d",$int);

        return  $code;

    }
    
    public function customer_number_create_main($company_id){
          
        $id  = DB::select('select MAX(client_code_main) from customer_mst where company_id = ' .$company_id );

        $int = (int)$id[0]->max + 1;
        return sprintf("%06d",$int);

    }

    // create new project's code　
    // public function project_code_create($company_id){
        
        
    //     if($company_id == '1'){

    //         $id         = DB::select("select to_char(nextval('customer_code_1_seq'), 'FM00000000')");

    //         return $this->setFirstCodeProject((int)$id[0]->to_char);

    //     }else {
            
    //         $id         = DB::select("select to_char(nextval('customer_code_2_seq'), 'FM00000000')");

    //         return $this->setFirstCodeProject((int)$id[0]->to_char);
           
    //     }

    // }
    function char_at($str, $pos)
    {
      return $str{$pos};
    }
    
    // public function get_max_code_project($company_id){
     
    //    $company = Company_MST::where('id',$company_id)->first();
    //    return sprintf("%04d",$company->project_max_code + 1);
    // }

    public function get_max_code_project($company_id){
        
           
           $projects = Project_MST::where('company_id',$company_id)->get();
           if($projects->count() >0) {
              
              $company  = Company_MST::where('id',$company_id)->first();
              $max_code = $company->project_max_code;

              return $this->setFirstCodeProject($max_code);

           }
           
           return $this->setFirstCodeProject(1);
          
    }

    public function setFirstCodeProject($item){
           

        switch ($item) {

            case 1<=$item && $item <= 999:
                return 'Z'.sprintf("%03d",$item);
                break;

            case 1000<=$item && $item <= 1999:
                return 'Y'.sprintf("%03d",$item-1000);
                break;

            case 2000<=$item && $item <= 2999:
                return 'X'.sprintf("%03d",$item-2000);
                break;

            case 3000<=$item && $item <= 3999:
                return 'U'.sprintf("%03d",$item-3000);
                break;

            case 4000<=$item && $item <= 4999:
                return 'T'.sprintf("%03d",$item-4000);
                break;

            case 5000<=$item && $item <= 5999:
                return 'R'.sprintf("%03d",$item-5000);
                break;

            case 6000<=$item && $item <= 6999:
                return 'Q'.sprintf("%03d",$item-6000);
                break;

            case 7000<=$item && $item <= 7999:
                return 'P'.sprintf("%03d",$item-7000);
                break;

            case 8000<=$item && $item <= 8999:
                return 'O'.sprintf("%03d",$item-8000);
                break;

            case 9000<=$item && $item <= 9999:
                return 'O'.sprintf("%03d",$item-9000);
                break;
            case  $item > 9999:
                return 500;
                break;
            default:
                return 'Z001';

        }

   }



    //ログイン時のログ
    public function authenticate_Log($process){

            $log           = new Log();
            $log->user_id  = Auth::user()->id;
            $log->company_id  = Auth::user()->company_id;
            $log->process  = $process;
            
            if($log->save()){

                return true;
                
            }
            return false;

    }
    //新規の場合
    public function log_create($user_id,$record_id,$table_id,$process,$form_id,$company_id,$name,$code,$newdate,$olddate){

            $log             = new Log();
            $log->user_id    = Auth::user()->id;
            $log->process    = $process;
            $log->table_id   = $table_id;
            $log->record_id  = $record_id;
            $log->form_id    = $form_id;
            $log->company_id = $company_id;
            $log->name       = $name;
            $log->code       = $code; 
            $log->new_data   = $newdate;
            $log->old_data   = $olddate;
            $log->save();

    }
    //UPDATEの場合
    public function log_update($object,$table_id,$form_id,$company_id,$name,$code){

        $a = $object->getAttributes();
        $b = $object->getOriginal();

   
        foreach($a as $x => $y) {
          
          if(strcmp($y,$b[$x]) != 0){

            $log             = new Log();
            $log->user_id    = Auth::user()->id;
            $log->item       = $x;
            $log->record_id  = $object->id;
            $log->table_id   = $table_id;
            $log->old_data   = $b[$x];
            $log->new_data   = $y;
            $log->item       = $x;
            $log->process    = "UPDATE"; 
            $log->form_id    = $form_id;        
            $log->company_id = $company_id;
            $log->name       = $name;
            $log->code       = $code; 
            $log->save();
            
          }


        }
          

    }
    //親の情報を変更
    public function log_change($user_id,$process,$table_id,$item,$old_data,$new_data){
 
            $log             = new Log();
            $log->user_id    = Auth::user()->id;
            $log->process    = $process;
            $log->table_id   = $table_id;
            $log->item       = $item;
            $log->old_data   = $old_data;
            $log->new_data   = $new_data;

            $log->save();

    }
    
    public function getDate($add_second){
       
       $time     = Carbon::now();
       $time     = $time->addSeconds($add_second)->format('Y-m-d H:i:s');
       
       return $time;

    }

    



    public function checkGroup(){
          
         DB::beginTransaction();
         $groups = Group_MST::whereDate('updated_at', Carbon::today())
                            ->orWhereDate('created_at', Carbon::today())
                            ->get();
        // $dt = new Carbon();
        // $dt = $dt->addSecond(3);
        
         foreach ($groups as $group) {
             
             $diagram = new Diagram();

             $projects = Project_MST::where('group_id',$group->id)->get();
             if(!$projects->isEmpty()){

                foreach ($projects as $project) {

                     $diagram = new Diagram();
                     $diagram->company_id        = $project->company_id;
                     $diagram->company_name      = $project->company->abbreviate_name;
                     $diagram->headquarters_code = $project->headquarter->headquarter_list_code;
                     $diagram->headquarters      = $project->headquarter->headquarters;
                     $diagram->department_code   = $project->department->department_list_code;
                     $diagram->department_name   = $project->department->department_name;
                     $diagram->group_code        = $group->group_list_code;
                     $diagram->group_name        = $group->group_name;
                     $diagram->project_code      = $project->project_code;
                     $diagram->project_name      = $project->project_name;
                     $diagram->cost_code         = $project->group->cost_code;
                     $diagram->cost_name         = $project->group->cost_name;
                     $diagram->project_grp_code  = $project->get_code;
                     $diagram->project_grp_name  = $project->get_name;
                     $diagram->pj_id             = $project->id;
                     $diagram->created_at        = $group->updated_at;
                     $diagram->flag              = $group->status;
                     $diagram->id = $this->getMaxId();
                     $diagram->save();
                }
            }
                
            $costs = Cost_MST::where('group_id',$group->id)->get();

            if(!$costs->isEmpty()){
                
                foreach ($costs as $cost) {

                         $diagram = new Diagram();
                         $diagram->company_id                    = $cost->company_id;
                         $diagram->company_name                  = $cost->company->abbreviate_name;
                         $diagram->headquarters_code             = $cost->headquarter->headquarter_list_code;
                         $diagram->headquarters                  = $cost->headquarter->headquarters;
                         $diagram->department_code               = $cost->department->department_list_code;
                         $diagram->department_name               = $cost->department->department_name;
                         $diagram->group_code                    = $group->group_list_code;
                         $diagram->group_name                    = $group->group_name;

                         if($cost->type == 1){
                                
                                $diagram->cost_code         = $cost->cost_code;
                                $diagram->cost_name         = $cost->cost_name;

                         }else {
                                
                                $diagram->sales_management_code         = $cost->cost_code;
                                $diagram->sales_management              = $cost->cost_name;
                         }

                         $diagram->tree_id                       = $cost->id;
                         $diagram->created_at                    = $cost->updated_at;
                         $diagram->flag                          = $group->status;
                         $diagram->id = $this->getMaxId();
                         $diagram->save();
                }        

             }

         }

          DB::commit();

    }

    public function checkDepartment(){
          
         DB::beginTransaction();
         $departments = Department_MST::whereDate('updated_at', Carbon::today())                            
                      ->orWhereDate('created_at', Carbon::today())
                      ->get();
         // $dt = new Carbon();
         // $dt = $dt->addSecond(5);
         foreach ($departments as $department) {
             
            

             $projects = Project_MST::where('department_id',$department->id)->get();
             if(!$projects->isEmpty()){

                foreach ($projects as $project) {

                     $diagram = new Diagram();
                     $diagram->company_id        = $project->company_id;
                     $diagram->company_name      = $project->company->abbreviate_name;
                     $diagram->headquarters_code = $project->headquarter->headquarter_list_code;
                     $diagram->headquarters      = $project->headquarter->headquarters;
                     $diagram->department_code   = $department->department_list_code;
                     $diagram->department_name   = $department->department_name;
                     $diagram->group_code        = $project->group->group_list_code;
                     $diagram->group_name        = $project->group->group_name;
                     $diagram->project_code      = $project->project_code;
                     $diagram->project_name      = $project->project_name;
                     $diagram->cost_code         = $project->group->cost_code;
                     $diagram->cost_name         = $project->group->cost_name;
                     $diagram->project_grp_code  = $project->get_code;
                     $diagram->project_grp_name  = $project->get_name;
                     $diagram->pj_id             = $project->id;
                     $diagram->created_at        = $department->updated_at;
                     $diagram->flag              = $department->status;
                     $diagram->id = $this->getMaxId();
                     $diagram->save();

                }
             }
               
             $costs = Cost_MST::where('department_id',$department->id)->get();
             
             if(!$costs->isEmpty()) {

                foreach ($costs as $cost) {
                     
                     $diagram = new Diagram();
                     $diagram->company_id                    = $cost->company_id;
                     $diagram->company_name                  = $cost->company->abbreviate_name;
                     $diagram->headquarters_code             = $cost->headquarter->headquarter_list_code;
                     $diagram->headquarters                  = $cost->headquarter->headquarters;
                     $diagram->department_code               = $department->department_list_code;
                     $diagram->department_name               = $department->department_name;
                     $diagram->group_code                    = $cost->group->group_list_code;
                     $diagram->group_name                    = $cost->group->group_name;
                     if($cost->type == 1){
                            
                            $diagram->cost_code         = $cost->cost_code;
                            $diagram->cost_name         = $cost->cost_name;

                     }else {
                            
                            $diagram->sales_management_code         = $cost->cost_code;
                            $diagram->sales_management              = $cost->cost_name;
                     }
                     $diagram->tree_id                       = $cost->id;
                     $diagram->created_at                    = $department->updated_at;
                     $diagram->flag                          = $department->status;
                     $diagram->id = $this->getMaxId();
                     $diagram->save();
                }

             }
           
         }

          DB::commit();

    }

    public function checkHeadquarter(){
          
         DB::beginTransaction();
         $headquarters = Headquarters_MST::whereDate('updated_at', Carbon::today())                            
                       ->orWhereDate('created_at', Carbon::today())
                       ->get();
         // $dt = new Carbon();
         // $dt = $dt->addSecond(7);
         foreach ($headquarters as $headquarter) {
             
             $projects = Project_MST::where('headquarter_id',$headquarter->id)->get();

             if(!$projects->isEmpty()){
                 
                 foreach ($projects as $project) {

                     $diagram = new Diagram();
                     $diagram->company_id        = $project->company_id;
                     $diagram->company_name      = $project->company->abbreviate_name;
                     $diagram->headquarters_code = $headquarter->headquarter_list_code;
                     $diagram->headquarters      = $headquarter->headquarters;
                     $diagram->department_code   = $project->department->department_list_code;
                     $diagram->department_name   = $project->department->department_name;
                     $diagram->group_code        = $project->group->group_list_code;
                     $diagram->group_name        = $project->group->group_name;
                     $diagram->project_code      = $project->project_code;
                     $diagram->project_name      = $project->project_name;
                     $diagram->cost_code         = $project->group->cost_code;
                     $diagram->cost_name         = $project->group->cost_name;
                     $diagram->project_grp_code  = $project->get_code;
                     $diagram->project_grp_name  = $project->get_name;
                     $diagram->pj_id             = $project->id;
                     $diagram->created_at        = $headquarter->updated_at;
                     $diagram->flag              = $headquarter->status;
                     $diagram->id = $this->getMaxId();
                     $diagram->save();

                 }


             }
             

             $costs = Cost_MST::where('headquarter_id',$headquarter->id)->get();
             
             if(!$costs->isEmpty()){

                foreach ($costs as $cost) {
                         
                         $diagram = new Diagram();
                         $diagram->company_id                    = $cost->company_id;
                         $diagram->company_name                  = $cost->company->abbreviate_name;
                         $diagram->headquarters_code             = $headquarter->headquarter_list_code;
                         $diagram->headquarters                  = $headquarter->headquarters;
                         $diagram->department_code               = $cost->department->department_list_code;
                         $diagram->department_name               = $cost->department->department_name;
                         $diagram->group_code                    = $cost->group->group_list_code;
                         $diagram->group_name                    = $cost->group->group_name;
                         if($cost->type == 1){
                                
                                $diagram->cost_code         = $cost->cost_code;
                                $diagram->cost_name         = $cost->cost_name;

                         }else {
                                
                                $diagram->sales_management_code         = $cost->cost_code;
                                $diagram->sales_management              = $cost->cost_name;
                         }
                         $diagram->tree_id                       = $cost->id;
                         $diagram->created_at                    = $headquarter->updated_at;
                         $diagram->flag                          = $headquarter->status;

                         $diagram->id = $this->getMaxId();
                         $diagram->save();

                }
             }

         }

          DB::commit();

    }
    
    public function checkProject(){
          
        DB::beginTransaction();

            // $projects = Project_MST::whereDate('updated_at', Carbon::today())      
            //        ->orWhereDate('created_at', Carbon::today())
            //        ->get();
            $date  = Carbon::today();
            $projects = Project_MST::whereDate('updated_at', Carbon::today()->subDay(1))                            
                       ->orWhereDate('created_at', Carbon::today()->subDay(1))
                       ->get();
            
            foreach ($projects as $project) {
             
                 $diagram = new Diagram();

                 if($project){
                     
                     $diagram->company_id        = $project->company_id;
                     $diagram->company_name      = $project->company->abbreviate_name;
                     $diagram->headquarters_code = $project->headquarter->headquarter_list_code;
                     $diagram->headquarters      = $project->headquarter->headquarters;
                     $diagram->department_code   = $project->department->department_list_code;
                     $diagram->department_name   = $project->department->department_name;
                     $diagram->group_code        = $project->group->group_list_code;
                     $diagram->group_name        = $project->group->group_name;
                     $diagram->project_code      = $project->project_code;
                     $diagram->project_name      = $project->project_name;
                     $diagram->cost_code         = $project->group->cost_code;
                     $diagram->cost_name         = $project->group->cost_name;
                     $diagram->project_grp_code  = $project->get_code;
                     $diagram->project_grp_name  = $project->get_code_name;
                     $diagram->pj_id             = $project->id;
                     $diagram->created_at        = $this->getTimeForDiagram();
                     $diagram->flag              = $project->status;

                 } 
                 
                 $diagram->id = $this->getMaxId();
                 $diagram->save();

            }

         // $dt = new Carbon();
         // $dt = $dt->addSecond(9);

          DB::commit();

    }
    
    public function checkCost(){
          
         DB::beginTransaction();
         // $costs = Cost_MST::whereDate('updated_at', Carbon::today())                            
         //        ->orWhereDate('created_at', Carbon::today())
         //        ->get();
         $date  = Carbon::today();
         $costs = Cost_MST::whereDate('updated_at', Carbon::today()->subDay(1))                            
                       ->orWhereDate('created_at', Carbon::today()->subDay(1))
                       ->get();
       
         foreach ($costs as $cost) {
             
             $diagram = new Diagram();
           
             if($cost){
                 
                 $diagram->company_id        = $cost->company_id;
                 $diagram->company_name      = $cost->company->abbreviate_name;
                 $diagram->headquarters_code = $cost->headquarter->headquarter_list_code;
                 $diagram->headquarters      = $cost->headquarter->headquarters;

                 if($cost->department_id != null){

                   $diagram->department_code   = $cost->department->department_list_code;
                   $diagram->department_name   = $cost->department->department_name;
                 }

                if($cost->group_id != null){

                     $diagram->group_code        = $cost->group->group_list_code;
                     $diagram->group_name        = $cost->group->group_name;

                }

                 if($cost->type == 1){
                        
                        $diagram->cost_code         = $cost->cost_code;
                        $diagram->cost_name         = $cost->cost_name;

                 }else {
                        
                        $diagram->sales_management_code         = $cost->cost_code;
                        $diagram->sales_management              = $cost->cost_name;
                 }

                 $diagram->tree_id           = $cost->id;
                 $diagram->created_at        = $this->getTimeForDiagram();
                 $diagram->flag              = $cost->status;


             }
             
             $diagram->id = $this->getMaxId();
             $diagram->save();

         }
       
        DB::commit();

    }

    public function getMaxId(){
         
         $id  = DB::select('select MAX(id) from organization_history');
      
         return $id[0]->max+1;
    }
    

    //テーブルコメント欄取得
    public function tablecomnet_get(){

        $comment = DB::select("select
        information_schema.columns.column_name,
        information_schema.columns.data_type,
        (select description from pg_description where
         pg_description.objoid=pg_stat_user_tables.relid and
         pg_description.objsubid=information_schema.columns.ordinal_position
        )
        from
         pg_stat_user_tables,
         information_schema.columns
        where
        pg_stat_user_tables.relname= ?
        and pg_stat_user_tables.relname=information_schema.columns.table_name", ['company']);
    }

        //テーブルコメント欄取得
    public function field_name_josn(){

    $json = json_encode(['id' => 'ユーザーID', 'usr_code' => '社員コード','usr_name' => 'ユーザー名', 'rule' => '画面ルールID','pw' => 'PW', 'email_address' => 'メールアドレス','company_id' => '会社ID', 'headquarter_id' => '事業本部ID','department_id' => '部署ID', 'group_id' => 'グループID','retire' => '退職', 'updated_at' => '更新日', 'created_at' => '作成日','position_id' => '役職ID','login_first' => 'ログイン', 'password_chenge_date' => 'pw変更']);
    
    dd($json);
    
    //ルールアクション
      foreach ($menus as $check) {
        $old_Rule_log[$check->id ] = $check->link_name;
   }
        dd($old_Rule_log);
    
    }
    
    //-- Newをパスワード生成する
    //   受取パラメータ：なし
    //   返信パラメータ：パスワード
    //  nobusada
    
    public static function New_password_create(){
        //最小桁
        $password_min = system::where('f_setting_group','login')->where('f_setting_name','password_min')->first();
        //最大桁
        $password_max = system::where('f_setting_group','login')->where('f_setting_name','password_max')->first();
        //使用文字
        $password_char1 = system::where('f_setting_group','login')->where('f_setting_name','password_char1')->first();
        $password_char2 = system::where('f_setting_group','login')->where('f_setting_name','password_char2')->first();
        $password_char3 = system::where('f_setting_group','login')->where('f_setting_name','password_char3')->first();
        $password_char4 = system::where('f_setting_group','login')->where('f_setting_name','password_char4')->first();

        //vars
        $passw = array();
        $arr1 = str_split($password_char1->f_setting_data,1);
        $arr2 = str_split($password_char2->f_setting_data,1);
        $arr3 = str_split($password_char3->f_setting_data,1);
        $arr4 = str_split($password_char4->f_setting_data,1);
        $passw_strings = array(
            $arr1,
            $arr2,
            $arr3,
            $arr4,
        );
        $pw_length      = rand($password_min->f_setting_data,$password_max->f_setting_data);
        //logic
        while (count($passw) < $pw_length) {
            // 4種類必ず入れる
            if (count($passw) < 4) {
                $key = key($passw_strings);
                next($passw_strings);
            } else {
            // 後はランダムに取得
                $key = array_rand($passw_strings);
            }
            $passw[] = $passw_strings[$key][array_rand($passw_strings[$key])];
        }
        // 生成したパスワードの順番をランダムに並び替え
        shuffle($passw);

        return implode($passw);
    }
    
    public static function Time_array_Get(){
        $TIME_ARRAY = array(
            "09:00",
            "10:00",
            "11:00",
            "12:00",
            "13:00",
            "14:00",
            "15:00",
            "16:00",
            "17:00",
            "18:00",
            "19:00",
            "20:00",
            "21:00",
            "22:00",
            "23:00",
            "24:00",
            "00:00",
            "01:00",
            "02:00",
            "03:00",
            "04:00",
            "05:00",
            "06:00",
            "07:00",
            "08:00",
        );
        return $TIME_ARRAY;
    }


}


 ?>
