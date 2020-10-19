<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiDingOperatorRegionCode extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_operators_region_codes';
	
	protected $fillable = [
		'ProviderCode',
		'RegionCode',
		];
	
	public function region(){ return $this->hasOne('App\Models\ApiDingRegion','RegionCode','RegionCode'); }
	
	public function operator(){ return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','ProviderCode'); }
}