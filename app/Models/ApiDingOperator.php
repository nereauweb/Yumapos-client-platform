<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingOperator extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_operators';

	protected $fillable = [
		'ProviderCode',
		'CountryIso',
		'Name',
		'ShortName',
		'ValidationRegex',
		'CustomerCareNumber',
		'LogoUrl',
		];
		
	public $products_type = '';

	public function region_codes(){ return $this->hasMany('App\Models\ApiDingOperatorRegionCode','ProviderCode','ProviderCode'); }

	public function regions(){
		return $this->hasManyThrough(
            'App\Models\ApiDingRegion',
            'App\Models\ApiDingOperatorRegionCode',
            'RegionCode',
            'RegionCode',
            'id',
            'operator_id'
        );
	}

	public function payment_types(){ return $this->hasMany('App\Models\ApiDingOperatorPaymentType','ProviderCode'); }


	public function products(){ return $this->hasMany('App\Models\ApiDingProduct','ProviderCode','ProviderCode'); }

	public function country()
    {
        return $this->hasOne(ApiDingCountry::class, 'CountryIso', 'CountryIso');
    }
	
	public function products_type(){
		
		if ($this->products_type==''){
			$this->products_type = $this->products()->first() ? $this->products()->first()->type() : 'Undefined';
		}
		return $this->products_type;
		
	}
	
	public function configurations(){ 
		return $this->hasMany('App\Models\ApiDingOperatorConfiguration','operator_ProviderCode','ProviderCode'); 
	}
	
	public function configuration($group_id){
		return $this->configurations->where('group_id', $group_id)->first();
	}

}
