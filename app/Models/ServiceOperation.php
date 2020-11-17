<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ServiceOperation extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'service_operations';
	
	protected $fillable = [
		'provider',
		'user_id',
		'api_reloadly_calls_id',
		'api_reloadly_operations_id',
		'reloadly_transactionId',
		'result',
		'request_operatorId',
		'request_local',
		'request_amount',
		'request_country_iso',
		'request_recipient_phone',
		'original_expected_destination_amount',
		'final_expected_destination_amount',
		'sent_amount',
		'user_amount',
		'user_gain',
		'final_amount',
		'user_discount',
		'platform_commission',
		'user_old_plafond',
		'user_new_plafond',
		'user_total_gain',
		'platform_total_gain',
		'report_status',
		'report_notes',
		];
		
	public function reloadly_call(){ 
		return $this->hasOne('App\Models\ApiReloadlyCall','id','api_reloadly_calls_id'); 
	}
	
	public function reloadly_operation(){ 
		return $this->hasOne('App\Models\ApiReloadlyOperation','id','api_reloadly_operations_id'); 
	}
	
	public function operator(){ 
		if ($this->provider == 'reloadly'){
			return $this->hasOne('App\Models\ApiReloadlyOperator','operatorId','request_operatorId'); 
		}
		if ($this->provider == 'ding'){
			return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','request_ProviderCode'); 
		}
		return false;
	}
	
	public function user(){ 
		return $this->hasOne('App\User','id','user_id'); 
	}
	
}