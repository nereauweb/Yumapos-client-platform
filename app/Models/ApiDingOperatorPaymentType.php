<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiDingOperatorPaymentType extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_ding_operators_payment_types';
	
	protected $fillable = [
		'ProviderCode',
		'payment_type',
		];
	
	public function operator(){ return $this->hasOne('App\Models\ApiDingOperator','ProviderCode','ProviderCode'); }
	
	
}