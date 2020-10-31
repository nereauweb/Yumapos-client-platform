<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingProductConfiguration extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_products_configurations';
	
	protected $fillable = [
		'product_id',
		'group_id',
		'fx_delta_percent',
		'discount_percent',
		'enabled',
		];
	
	public function amounts(){ 
		return $this->hasMany('App\Models\ApiDingProductConfigurationAmount','parent_id'); 
	}
	
	public function amount($original_amount){
		return $this->amounts->where('original_amount', $original_amount)->first();
	}
	
}