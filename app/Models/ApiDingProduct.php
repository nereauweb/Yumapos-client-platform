<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingProduct extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_products';

	protected $fillable = [
		'ProviderCode',
		'SkuCode',
		'LocalizationKey',
		'CommissionRate',
		'ProcessingMode',
		'RedemptionMechanism',
		'ValidityPeriodIso',
		'UatNumber',
		'AdditionalInformation',
		'DefaultDisplayText',
		'RegionCode',
		'LookupBillsRequired',
		'DisplayText',
		'DescriptionMarkdown',
		'ReadMoreMarkdown',
		'description_localization_key',
		'description_language_code',
		];

	public function setting_definitions(){ return $this->hasMany('App\Models\ApiDingProductSettingDefinition','product_id'); }
	public function maximum(){ return $this->hasOne('App\Models\ApiDingProductMaximum','product_id'); }
	public function minimum(){ return $this->hasOne('App\Models\ApiDingProductMinimum','product_id'); }
	public function benefits(){ return $this->hasMany('App\Models\ApiDingProductBenefit','product_id', 'id'); }
	public function payment_types(){ return $this->hasMany('App\Models\ApiDingProductPaymentType','product_id'); }
	public function operator(){ return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','ProviderCode'); }
	
	public function type(){
		if ($this->minimum->SendValue==$this->maximum->SendValue){
			return 'FIXED';
		}
		return 'RANGE';
	}
	
	public function configurations(){ 
		return $this->hasMany('App\Models\ApiDingProductConfiguration','product_id','id'); 
	}
	
	public function configuration($group_id){
		return $this->configurations->where('group_id', $group_id)->first();
	}
	
	public function config_rate($group_id){
		$configuration = $this->configurations->where('group_id', $group_id)->first();
		return $configuration && $configuration->fx_delta_percent != 0 ? $this->fx->rate - $this->fx->rate * $configuration->fx_delta_percent / 100 : $this->fx->rate;
	}
	
	
	public function fx_rate(){
		return $this->minimum->ReceiveValue / $this->minimum->SendValue;
	}
	
}
