<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingRegion extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_regions';
	
	protected $fillable = [
		'RegionCode',
		'RegionName',
		'CountryIso',
		];
	
	public function operators(){ 
		return $this->hasManyThrough(
            'App\Models\ApiDingOperator',
            'App\Models\ApiDingOperatorRegionCode',
            'ProviderCode', 
            'ProviderCode',
            'RegionCode',
            'RegionCode' 
        );
	}
	
	public function country(){ return $this->hasOne('App\Models\ApiDingCountry', 'CountryIso', 'CountryIso'); }
	
	
}