<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AgentOperation extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agent_operations';
	
	protected $fillable = [
		'user_id',
		'service_operation_id',
		'original_amount',
		'applied_commission_id',
		'commission',
		];
		
	public function pointOperation(){ 
		return $this->hasOne('App\Models\ServiceOperation','id','service_operation_id'); 
	}
	
	public function user(){ 
		return $this->hasOne('App\User','id','user_id'); 
	}
	
}