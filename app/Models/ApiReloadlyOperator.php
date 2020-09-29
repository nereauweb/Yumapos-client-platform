<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiReloadlyOperator extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_operators';
	
	protected $fillable = [
		'operatorId',
		'name',
		'bundle',
		'data',
		'pin',
		'supportsLocalAmounts',
		'denominationType',
		'senderCurrencyCode',
		'senderCurrencySymbol',
		'destinationCurrencyCode',
		'destinationCurrencySymbol',
		'commission',
		'internationalDiscount',
		'localDiscount',
		'mostPopularAmount',
		'minAmount',
		'maxAmount',
		'localMinAmount',
		'localMaxAmount',
		];
	
	public function country(){ return $this->hasOne('App\Models\ApiReloadlyOperatorCountry','parent_id'); }
	public function fx(){ return $this->hasOne('App\Models\ApiReloadlyOperatorFxs','parent_id'); }
	public function logoUrls(){ return $this->hasMany('App\Models\ApiReloadlyOperatorLogoURL','parent_id'); }
	public function fixedAmounts(){ return $this->hasMany('App\Models\ApiReloadlyOperatorFixedAmount','parent_id'); }
	public function fixedAmountsDescriptions(){ return $this->hasMany('App\Models\ApiReloadlyOperatorFixedAmountDescription','parent_id'); }
	public function localFixedAmounts(){ return $this->hasMany('App\Models\ApiReloadlyOperatorLocalFixedAmount','parent_id'); }
	public function localFixedAmountsDescriptions(){ return $this->hasMany('App\Models\ApiReloadlyOperatorLocalFixedAmountDescription','parent_id'); }
	public function suggestedAmounts(){ return $this->hasMany('App\Models\ApiReloadlyOperatorSuggestedAmount','parent_id'); }
	public function suggestedAmountsMap(){ return $this->hasMany('App\Models\ApiReloadlyOperatorSuggestedAmountMap','parent_id'); }
		
	public function configurations(){ 
		return $this->hasMany('App\Models\ApiReloadlyOperatorConfiguration','operator_id','operatorId'); 
	}
	
	public function configuration($group_id){
		return $this->configurations->where('group_id', $group_id)->first();
	}
	
	public function config_rate($group_id){
		$configuration = $this->configurations->where('group_id', $group_id)->first();
		return $configuration && $configuration->fx_delta_percent != 0 ? $this->fx->rate - $this->fx->rate * $configuration->fx_delta_percent / 100 : $this->fx->rate;
	}
	
}