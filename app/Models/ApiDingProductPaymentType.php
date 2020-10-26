<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiDingProductPaymentType extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_products_payment_types';
	
	protected $fillable = [
		'product_id',
		'payment_type',
		];
	
	public function product(){ return $this->hasOne('App\Models\ApiDingProduct','id','product_id'); }
	
	
}