<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiReloadlyOperatorConfiguration extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_operators_configurations';
	
	protected $fillable = [
		'operator_id',
		'group_id',
		'fx_delta_percent',
		'discount_percent',
		'enabled',
		];
	
	public function amounts(){ 
		return $this->hasMany('App\Models\ApiReloadlyOperatorConfigurationAmount','parent_id'); 
	}
	
	public function amount($original_amount){
		return $this->amounts->where('original_amount', $original_amount)->first();
	}
	
	public function local_amounts(){ 
		return $this->hasMany('App\Models\ApiReloadlyOperatorConfigurationLocalAmount','parent_id'); 
	}
	
	public function local_amount($original_amount){
		return $this->local_amounts->where('original_amount', $original_amount)->first();
	}
	
}