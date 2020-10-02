<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Credit_check extends Model
{
        public $timestamps = true;
        protected $table = 'credit_check';
      
        public function getGetTimeAttribute(){

        	return Carbon::parse($this->attributes['get_time'])->format('Y-m-d');
        }
        
        public function getExpirationDateAttribute(){

        	return Carbon::parse($this->attributes['expiration_date'])->format('Y-m-d');
        }
}