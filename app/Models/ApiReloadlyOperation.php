<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiReloadlyOperation extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_operations';
	
	protected $fillable = [
		'transactionId',
		'operatorTransactionId',
		'customIdentifier',
		'recipientPhone',
		'recipientEmail',
		'senderPhone',
		'countryCode',
		'operatorId',
		'operatorName',
		'discount',
		'discountCurrencyCode',
		'requestedAmount',
		'requestedAmountCurrencyCode',
		'deliveredAmount',
		'deliveredAmountCurrencyCode',
		'transactionDate',
		'balance_pinDetail',
		'balance_oldBalance',
		'balance_newBalance',
		'balance_currencyCode',
		'balance_currencyName',
		'balance_updatedAt',
		];
}