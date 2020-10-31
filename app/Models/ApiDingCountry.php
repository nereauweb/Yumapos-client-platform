<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingCountry extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_countries';

	protected $fillable = [
		'CountryIso',
		'CountryName',
		];

	public function int_dial_infos(){
		return $this->hasMany('App\Models\ApiDingCountryInternationalDialingInformation','CountryIso','CountryIso');
	}

	public function region_codes(){ return $this->hasMany('App\Models\ApiDingCountryRegionCode','CountryIso','CountryIso'); }

	public function regions(){
		return $this->hasManyThrough(
            'App\Models\ApiDingRegion',
            'App\Models\ApiDingCountryRegionCode',
            'RegionCode',
            'RegionCode',
            'CountryIso',
            'CountryIso'
        );
	}

	public function operations()
    {
        return $this->hasMany(ApiDingOperator::class, 'CountryIso', 'CountryIso');
    }
}
