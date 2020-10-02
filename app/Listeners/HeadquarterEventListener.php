<?php
namespace App\Listeners;
use App\Events\HeadquarterChangeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Headquarters_MST;
use App\Department_MST;
use App\Group_MST;
use App\User;
use App\Concurrently;
use App\Project_MST;
use App\Cost_MST;
use DB;
use Auth;
use Crofun;
class HeadquarterEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LogEvent  $event
     * @return void
     */
    public function handle(HeadquarterChangeEvent $event)
    {
        DB::beginTransaction();

        try{

            $headquarter     = Headquarters_MST::where('id',$event->old_headquarter_id)->first();
            $headquarter_new = Headquarters_MST::where('id',$event->new_headquarter_id)->first();

            //ログ用の項目を作成
            $headquarter_name_log = $headquarter->headquarters .' → ' .$headquarter_new->headquarters;
            $headquarter_code_log = $headquarter->headquarter_list_code .' → ' .$headquarter_new->headquarter_list_code;

            //部署マスタに影響があるか。
            $Department_edit_data    =  Department_MST::where('headquarters_id', $headquarter->id)->where('status',true)->get();
            //ログ用の配列に設定をする。
            foreach ($Department_edit_data as $check) {

                $old_Rule_log[] = $check->department_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //部署マスタの更新
                Department_MST::where('headquarters_id', $headquarter->id)->where('status',true)->update(['headquarters_id' => $headquarter_new->id,'updated_at'  => Crofun::getDate(1)]);

                //ログの追加
                Crofun::log_create(Auth::user()->id,$headquarter->id,config('constant.GROUP'),config('constant.operation_Bulk_up'),config('constant.HEADQUATER_EDIT'),$headquarter->company_id,$headquarter_name_log,$headquarter_code_log,json_encode($old_Rule_log),null);
            }

            //ユーザーマスタに影響があるか。
            $user_edit_data    =  User::where('headquarter_id', $headquarter->id)->where('retire',false)->get();

            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($user_edit_data as $user_data) {

                $old_Rule_log[] = $user_data->usr_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //ユーザーマスタの更新
                User::where('headquarter_id', $headquarter->id)
                    ->where('retire',false)
                    ->update(['headquarter_id' => $headquarter_new->id]);

                //ログの追加
                Crofun::log_create(Auth::user()->id,$headquarter->id,config('constant.USER'),config('constant.operation_Bulk_up'),config('constant.HEADQUATER_EDIT'),$headquarter->company_id,$headquarter_name_log,$headquarter_code_log,json_encode($old_Rule_log),null);
            }

            //兼務マスタに影響があるか。
            $concurrently_edit_data    =  Concurrently::where('headquarter_id', $headquarter->id)->where('status',true)->get();
            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($concurrently_edit_data as $concurrently_data) {

                $old_Rule_log[] = $concurrently_data->usr_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //兼務マスタの更新
                Concurrently::where('headquarter_id',$headquarter->id)->where('status',true)->update(['headquarter_id'   => $headquarter_new->id]);    

                //ログの追加
                Crofun::log_create(Auth::user()->id,$headquarter->id,config('constant.CONCURRENTLY'),config('constant.operation_Bulk_up'),config('constant.HEADQUATER_EDIT'),$headquarter->company_id,$headquarter_name_log,$headquarter_code_log,json_encode($old_Rule_log),null);

            }

            //プロジェクトマスタに影響があるか。
            $project_edit_data    =  Project_MST::where('headquarter_id', $headquarter->id)->where('status',true)->get();
            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($project_edit_data as $project_data) {

                $old_Rule_log[] = $project_data->project_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //プロジェクトマスタの更新
                Project_MST::where('headquarter_id', $headquarter->id)->where('status',true)->update(['headquarter_id'  => $headquarter_new->id,'updated_at'  => Crofun::getDate(3)]);  

                //ログの追加
                Crofun::log_create(Auth::user()->id,$headquarter->id,config('constant.PROJECT'),config('constant.operation_Bulk_up'),config('constant.HEADQUATER_EDIT'),$headquarter->company_id,$headquarter_name_log,$headquarter_code_log,json_encode($old_Rule_log),null);
            }

            //原価マスタに影響があるか。
            $cost_edit_data    =  Cost_MST::where('headquarter_id', $headquarter->id)->where('status',true)->get();
            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($cost_edit_data as $cost_data) {

                $old_Rule_log[] = $cost_data->cost_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //プロジェクトマスタの更新
                Cost_MST::where('headquarter_id', $headquarter->id)->where('status',true)->update(['headquarter_id'  => $headquarter_new->id,'updated_at'  => Crofun::getDate(5)]);  

                //ログの追加
                Crofun::log_create(Auth::user()->id,$headquarter->id,config('constant.COST'),config('constant.operation_Bulk_up'),config('constant.HEADQUATER_EDIT'),$headquarter->company_id,$headquarter_name_log,$headquarter_code_log,json_encode($old_Rule_log),null);

            }


            //$diagrams = Diagram::where('headquarters_code',$headquarter->headquarters_code)->get();
          
            // foreach ($diagrams as $diagram) {
                 
            //       $d = new Diagram();
            //       $d->own_company       = $diagram->own_company;
            //       $d->company_name      = $diagram->company_name;
            //       $d->headquarters_code = $headquarter_new->headquarters_code;
            //       $d->headquarters      = $headquarter_new->headquarters;
            //       $d->department_code   = $diagram->department_code;
            //       $d->department_name   = $diagram->department_name;
            //       $d->group_code        = $diagram->group_code;
            //       $d->group_name        = $diagram->group_name;
            //       $d->project_code      = $diagram->project_code;
            //       $d->project_name      = $diagram->project_name;
            //       $d->cost_code         = $diagram->cost_code;
            //       $d->cost_name         = $diagram->cost_name;
            //       $d->project_grp_code  = $diagram->project_grp_code;
            //       $d->project_grp_name  = $diagram->project_grp_name;
            //       $d->sales_management_code = $diagram->sales_management_code;
            //       $d->sales_management      = $diagram->sales_management;
            //       $d->tree_id               = $diagram->tree_id;
            //       $d->topic                 = $diagram->topic;
            //       $d->updated_at            = date("Y-m-d h:i:s");
            //       $d->created_at            = date("Y-m-d h:i:s");
            //       $d->save();


            // }
            
              DB::commit();

        }catch(Exception $e) {

              echo 'Message: ' .$e->getMessage();
              DB::rollBack();
              return view('500');
        }
        

    }
}
?>