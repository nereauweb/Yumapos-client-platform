<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
	
	
}