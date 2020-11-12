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
		
	public $type = '';
	public $fx_rate = 0;

	public function setting_definitions(){ return $this->hasMany('App\Models\ApiDingProductSettingDefinition','product_id'); }
	public function maximum(){ return $this->hasOne('App\Models\ApiDingProductMaximum','product_id'); }
	public function minimum(){ return $this->hasOne('App\Models\ApiDingProductMinimum','product_id'); }
	public function benefits(){ return $this->hasMany('App\Models\ApiDingProductBenefit','product_id', 'id'); }
	public function payment_types(){ return $this->hasMany('App\Models\ApiDingProductPaymentType','product_id'); }
	public function operator(){ return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','ProviderCode'); }
	
	
	
	
	
	public function type(){
		if ($this->type==''){
			if ($this->minimum&&$this->maximum){
				$this->type = $this->minimum->SendValue==$this->maximum->SendValue ? 'FIXED' : 'RANGE';
			}
		}
		return $this->type;
	}
	
	public function fx_rate(){
		if ($this->fx_rate==0){
			if ($this->minimum&&$this->maximum){
				$this->fx_rate = round( $this->minimum->ReceiveValue / $this->minimum->SendValue , 3 );
			}
		}
		return $this->fx_rate;
	}
	
}
