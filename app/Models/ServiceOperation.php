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
		'api_reloadly_calls_id',		//reloadly
		'api_reloadly_operations_id',	//reloadly
		'reloadly_transactionId',		//reloadly
		'ding_TransferRef',				//ding
		'api_ding_call_id',				//ding
		'api_ding_operation_id',		//ding
		'api_mbs_operation_id',				//mbs
		'result',						//1
		'request_operatorId',			//reloadly
		'request_ProviderCode',			//ding
		'request_Prodotto',				//mbs
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
		'pin',
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

	public function ding_call(){
		return $this->hasOne('App\Models\ApiDingCall','id','api_ding_call_id');
	}

	public function ding_operation(){
		return $this->hasOne('App\Models\ApiDingOperation','id','api_ding_operation_id');
	}

	public function ding_operator(){
		return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','request_ProviderCode');
	}

	public function mbs_operation(){
		return $this->hasOne('App\Models\ApiMbsOperation','id','api_mbs_operation_id');
	}

	public function mbs_product(){
		return $this->hasOne('App\Models\ApiMbsProduct','Prodotto','request_Prodotto');
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
			if ($this->provider == 'mbs'){
				return $this->mbs_product->Operatore;
			}
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
		if ($this->provider == 'mbs'){
			return 'Italy';
		}
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
		if ($this->provider == 'mbs'){
			return '€';
		}
		return '';
	}

	public function user(){
		return $this->hasOne('App\User','id','user_id');
	}
	
	public function agent_operation(){ 
		return $this->hasOne('App\Models\AgentOperation','service_operation_id','id'); 
	}
	
	public function pin(){
		return preg_replace('/\x03/', '', $this->pin);
	}
	
}
