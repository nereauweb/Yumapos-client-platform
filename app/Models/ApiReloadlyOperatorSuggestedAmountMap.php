<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiReloadlyOperatorSuggestedAmountMap extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_operators_suggestedAmountsMap';
	
	protected $fillable = [
		'parent_id',
		'amount_sender',
		'amount_recipient',
		];
	
}