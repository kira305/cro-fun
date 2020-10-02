<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Department_MST;
use App\Group_MST;
class Contract_MST extends Model
{
        public $timestamps = false;
        protected $table = 'contract';
		
    public function company(){

        return $this->hasOne('App\Company_MST','id', 'company_id');

    }

    public function customer(){

        return $this->hasOne('App\Customer_details_MST','id', 'client_id');

    }

    public function headquarter(){

        return $this->hasOne('App\Headquarters_MST','id', 'headquarter_id');

    }
    
    public function department(){


        	return $this->hasOne('App\Department_MST','id', 'department_id');

    }

    public function group(){

        return $this->hasOne('App\Group_MST','id', 'group_id');

    }    
    public function project(){

        return $this->hasOne('App\Project_MST','id', 'project_id');
        }    
}
