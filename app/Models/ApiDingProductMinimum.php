<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingProductMinimum extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_products_minimums';
	
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