<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiDingCountryRegionCode extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_countries_region_codes';
	
	protected $fillable = [
		'CountryIso',
		'RegionCode',
		];
	
	public function region(){ return $this->hasOne('App\Models\ApiDingRegion','RegionCode','RegionCode'); }
	
	public function country(){ return $this->hasOne('App\Models\ApiDingCountry','CountryIso','CountryIso'); }
}