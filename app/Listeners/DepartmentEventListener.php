<?php

namespace App\Listeners;

use App\Events\DepartmentChangeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Department_MST;
use App\Group_MST;
use App\Project_MST;
use App\User;
use App\Concurrently;
use App\Diagram;
use App\Cost_MST;
use Log;
use DB;
use Crofun;
use Auth;
class DepartmentEventListener
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
    public function handle(DepartmentChangeEvent $event)
    {
        DB::beginTransaction();

        try{

            $department         =  Department_MST::where('id',$event->old_department_id)->first();
            $department_new     =  Department_MST::where('id',$event->new_department_id)->first();
            
            $headquarter_new_id =  $department_new->headquarter()->id;
            $department_new_id  =  $department_new->id;

            //ログ用の項目を作成
            $department_name_log = $department->department_name .' → ' .$department_new->department_name;
            $department_code_log = $department->department_list_code .' → ' .$department_new->department_list_code;

            //本部
            $headquarters_name_log = $department->headquarter()->headquarters .' → ' .$department_new->headquarter()->headquarters;
            $headquarters_code_log = $department->headquarter()->headquarter_list_code .' → ' .$department_new->headquarter()->headquarter_list_code;

            //グループマスタに影響があるか。
            $Group_edit_data    =  Group_MST::where('department_id', $event->old_department_id)->where('status',true)->get();
            //ログ用の配列に設定をする。
            foreach ($Group_edit_data as $check) {

                $old_Rule_log[] = $check->group_name;
            }


            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //グループマスタの更新
                Group_MST::where('department_id', $event->old_department_id)->where('status',true)
                         ->update(
                            ['department_id'   => $department_new_id,
                             'updated_at'      => Crofun::getDate(1)
                            ]);

                //ログの追加
                Crofun::log_create(Auth::user()->id,$department->id,config('constant.GROUP'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$department_name_log,$department_code_log,json_encode($old_Rule_log),null);
            }

            //ユーザーマスタに影響があるか。
            $user_edit_data    =  User::where('department_id', $department->id)->where('retire',false)->get();
            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($user_edit_data as $user_data) {

                $old_Rule_log[] = $user_data->usr_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //ユーザーマスタの更新
                User::where('department_id', $department->id)
                    ->where('retire',false)
                    ->update(['department_id' => $department_new_id]);

                //ログの追加
                Crofun::log_create(Auth::user()->id,$department->id,config('constant.USER'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$department_name_log,$department_code_log,json_encode($old_Rule_log),null);


                //ユーザー本部の更新は必要か
                if($department->headquarter()->id !=  $department_new->headquarter()->id ){
                    //ユーザー本部情報更新
                    User::where('department_id', $department_new_id)
                        ->where('retire',false)
                        ->update(['headquarter_id'=> $headquarter_new_id]);

                    //ログの追加
                    Crofun::log_create(Auth::user()->id,$department->id,config('constant.USER'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$headquarters_name_log,$headquarters_code_log,json_encode($old_Rule_log),null);
                }



            }

            //兼務マスタに影響があるか。
            $concurrently_edit_data    =  Concurrently::where('department_id', $department->id)->where('status',true)->get();
            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($concurrently_edit_data as $concurrently_data) {

                $old_Rule_log[] = $concurrently_data->usr_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //兼務マスタの更新
                Concurrently::where('department_id',$department->id)->where('status',true)->update(['department_id'   => $department_new_id]);    

                //ログの追加
                Crofun::log_create(Auth::user()->id,$department->id,config('constant.CONCURRENTLY'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$department_name_log,$department_code_log,json_encode($old_Rule_log),null);


                //兼務の本部の更新は必要か
                if($department->headquarter()->id !=  $department_new->headquarter()->id ){
                    //兼務の本部情報更新
                    Concurrently::where('department_id',$department_new_id)->where('status',true)->update(['headquarter_id'  => $headquarter_new_id]);

                    //ログの追加
                    Crofun::log_create(Auth::user()->id,$department->id,config('constant.CONCURRENTLY'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$headquarters_name_log,$headquarters_code_log,json_encode($old_Rule_log),null);
                }

            }

            //プロジェクトマスタに影響があるか。
            $project_edit_data    =  Project_MST::where('department_id', $event->old_department_id)->where('status',true)->get();
            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($project_edit_data as $project_data) {

                $old_Rule_log[] = $project_data->project_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //プロジェクトマスタの更新
                Project_MST::where('department_id', $event->old_department_id)->where('status',true)->update(
                    ['department_id'  => $event->new_department_id,
                     'updated_at'     => Crofun::getDate(3)
                    ]);  

                //ログの追加
                Crofun::log_create(Auth::user()->id,$department->id,config('constant.PROJECT'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$department_name_log,$department_code_log,json_encode($old_Rule_log),null);


                //兼務の本部の更新は必要か
                if($department->headquarter()->id !=  $department_new->headquarter()->id ){
                    //プロジェクトの本部情報更新
                    Project_MST::where('department_id', $event->new_department_id)->where('status',true)->update(['headquarter_id' => $headquarter_new_id]);

                    //ログの追加
                    Crofun::log_create(Auth::user()->id,$department->id,config('constant.PROJECT'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$headquarters_name_log,$headquarters_code_log,json_encode($old_Rule_log),null);
                }

            }

            //原価マスタに影響があるか。
            $cost_edit_data    =  Cost_MST::where('department_id', $event->old_department_id)->where('status',true)->get();
            //配列の初期化
            $old_Rule_log = array();

            //ログ用の配列に設定をする。
            foreach ($cost_edit_data as $cost_data) {

                $old_Rule_log[] = $cost_data->cost_name;
            }

            //ログ用の配列に設定が有れば、ログにセット及び、更新を行う。
            if(empty($old_Rule_log) == false){
                //プロジェクトマスタの更新
                Cost_MST::where('department_id', $event->old_department_id)->where('status',true)->update(['department_id'  => $event->new_department_id,'updated_at'  => Crofun::getDate(5)]);  

                //ログの追加
                Crofun::log_create(Auth::user()->id,$department->id,config('constant.COST'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$department_name_log,$department_code_log,json_encode($old_Rule_log),null);


                //兼務の本部の更新は必要か
                if($department->headquarter()->id !=  $department_new->headquarter()->id ){
                    //プロジェクトの本部情報更新
                    Cost_MST::where('department_id', $event->new_department_id)->where('status',true)->update(['headquarter_id' => $headquarter_new_id]);

                    //ログの追加
                    Crofun::log_create(Auth::user()->id,$department->id,config('constant.COST'),config('constant.operation_Bulk_up'),config('constant.DEPARTMENT_EDIT'),$department->headquarter()->company_id,$headquarters_name_log,$headquarters_code_log,json_encode($old_Rule_log),null);
                }

            }

            //$diagrams = Diagram::where('department_code',$department->department_code)->get();

            // foreach ($diagrams as $diagram) {
                 
            //       $d = new Diagram();
            //       $d->own_company       = $diagram->own_company;
            //       $d->company_name      = $diagram->company_name;
            //       $d->headquarters_code = $diagram->headquarters_code;
            //       $d->headquarters      = $diagram->headquarters;
            //       $d->department_code   = $department_new->department_code;
            //       $d->department_name   = $department_new->department_name;
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
