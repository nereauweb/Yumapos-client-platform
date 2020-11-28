<?php

namespace App\Models;

use App\Models\ServiceCountry;

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
		'ding_TransferRef',
		'api_ding_operation_id',
		'result',
		'request_operatorId',
		'request_ProviderCode',
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
		'agent_commission',
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

	public function reloadly_operator(){
//		return $this->hasOne('App\Models\ApiReloadlyOperator','id','request_operatorId');
        return $this->hasOne('App\Models\ApiReloadlyOperator','operatorId','request_operatorId');
    }

	public function ding_operation(){
		return $this->hasOne('App\Models\ApiDingOperation','id','api_ding_operation_id');
	}

	public function ding_operator(){
		return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','request_ProviderCode');
	}

	public function operator(){
		if ($this->provider == 'reloadly'){
			return $this->reloadly_operator;
		}
		if ($this->provider == 'ding'){
			return $this->ding_operator;
		}
		return false;
	}

	public function operator_name(){
		try
		{
			if ($this->provider == 'reloadly'){
				return $this->reloadly_operator->name;
			}
			if ($this->provider == 'ding'){
				return $this->ding_operator->Name;
			}
		}
		catch(\ErrorException $ex)
		{
			return '';
		}

		return '';
	}

	public function country_name(){
		try
		{
			return ServiceCountry::where('iso',$this->request_country_iso)->first()->name;
		}
		catch(Exception $ex)
		{
			return '';
		}
	}

	public function destination_currency_symbol(){
		if ($this->provider == 'reloadly'){
			return $this->reloadly_operator->destinationCurrencySymbol;
		}
		if ($this->provider == 'ding'){
			return $this->ding_operation->ReceiveCurrencyIso;
		}
		return '';
	}

	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}

}
