<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingProductSettingDefinition extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_products_setting_definitions';
	
	protected $fillable = [
		'product_id',
		'Name',
		'Description',
		'IsMandatory',
		];
	
	public function product(){ return $this->hasOne('App\Models\ApiDingProduct','id','product_id'); }
	
	
}