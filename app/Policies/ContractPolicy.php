<?php

namespace App\Policies;

use App\User;
use App\Contract_MST;
use App\Rule_action;
use App\Concurrently;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the contract_ m s t.
     *
     * @param  \App\User  $user
     * @param  \App\Contract_MST  $contractMST
     * @return mixed
     */
    public function view(User $user)
    {
       $rule_action = Rule_action::where('rule_id',$user->rule)->where('action_id',config('constant.CONTRACT_INDEX'))->first();
       
       if($rule_action){

        return true;

       }else {

        return false;

       }
    }
    
    public function display(User $user, Contract_MST $contract)
    {

        /*ルールマスタを見て参照範囲の確認*/
        $rule_action = Rule_action::where('rule_id',$user->rule)
                     ->where('action_id',config('constant.CONTRACT_DISPLAY'))
                     ->first();
        if($rule_action){

                        /*管理者フラグなら全部OK*/
            if($user->getrole->admin_flag == 1){
           
                return true;
            }

            if($user->company_id == $contract->company_id && ($contract->department_id == null || $contract->group_id == null)){

                return true;
            }

            if($user->company_id == $contract->company_id && $user->position->company_look == true){

                return true;
            }
            /*ルールマスタを見て参照範囲の確認*/
            if($user->headquarter_id == $contract->headquarter_id && $user->position->headquarter_look == true){

                return true;
            }
          
            if($user->department_id == $contract->department_id && $user->position->department_look == true){

                return true;
            }
      
            if($user->group_id == $contract->group_id && $user->position->group_look == true){

                return true;
            }
          
            $concurently = Concurrently::where('usr_id',$user->id)->where('status',true)->get();

            foreach ($concurently as $c) {
               

                if($c->headquarter_id == $contract->headquarter_id && $c->position->headquarter_look == true){

                    return true;
                }

                if($c->department_id == $contract->department_id && $c->position->department_look == true){

                    return true;
                }

                if($c->group_id     == $contract->group_id && $c->position->group_look == true){

                    return true;
                }
               

            }


        }
        return false;
    }
    

    /**
     * Determine whether the user can create contract_ m s ts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the contract_ m s t.
     *
     * @param  \App\User  $user
     * @param  \App\Contract_MST  $contractMST
     * @return mixed
     */
    public function update(User $user, Contract_MST $contractMST)
    {
        //
    }

    /**
     * Determine whether the user can delete the contract_ m s t.
     *
     * @param  \App\User  $user
     * @param  \App\Contract_MST  $contractMST
     * @return mixed
     */
    public function delete(User $user, Contract_MST $contractMST)
    {
        //
    }

    /**
     * Determine whether the user can restore the contract_ m s t.
     *
     * @param  \App\User  $user
     * @param  \App\Contract_MST  $contractMST
     * @return mixed
     */
    public function restore(User $user, Contract_MST $contractMST)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the contract_ m s t.
     *
     * @param  \App\User  $user
     * @param  \App\Contract_MST  $contractMST
     * @return mixed
     */
    public function forceDelete(User $user, Contract_MST $contractMST)
    {
        //
    }
}
