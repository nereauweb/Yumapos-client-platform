<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiDingProductMaximum extends Model
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_products_maximums';
	
	protected $fillable = [
		'product_id',
		'CustomerFee',
		'DistributorFee',
		'ReceiveValue',
		'ReceiveCurrencyIso',
		'ReceiveValueExcludingTax',
		'TaxRate',
		'TaxName',
		'TaxCalculation',
		'SendValue',
		'SendCurrencyIso',
		];
	
	public function product(){ return $this->hasOne('App\Models\ApiDingProduct','id','product_id'); }
	
	
}