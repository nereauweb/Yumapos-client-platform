<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiMbsOperation extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_mbs_operations';
	
	protected $fillable = [
		'operation_id',
		'product',
		'user_id',
		'number',
		'amount',
		'platform_balance_before',
		'platform_balance_after',
		'cost',
		'response',
		'ref',
		'pin',
		'pin_serial',
		'pin_expiry',
		];
		
	public function configurations(){ 
		return $this->hasOne('App\Models\ApiMbsCall','operation_id','operation_id'); 
	}
}