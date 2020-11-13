<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingOperation extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_operations';
	
	protected $fillable = [
		'TransferRef',
		'DistributorRef',
		'SkuCode',
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
		'CommissionApplied',
		'StartedUtc',
		'CompletedUtc',
		'ProcessingState',
		'ReceiptText',
		'ReceiptParams',
		'AccountNumber',
	];
}