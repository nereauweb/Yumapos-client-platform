<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiDingProductBenefit extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_products_benefits';
	
	protected $fillable = [
		'product_id',
		'benefit',
		];
	
	public function product(){ return $this->hasOne('App\Models\ApiDingProduct','id','product_id'); }
	
	
}