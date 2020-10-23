<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiDingCountryInternationalDialingInformation extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_countries_int_dial_infos';
	
	protected $fillable = [
		'CountryIso',
		'Prefix',
		'MinimumLength',
		'MaximumLength',
		];
		
	public function country(){ return $this->hasOne('App\Models\ApiDingCountry','CountryIso','CountryIso'); }
	
}