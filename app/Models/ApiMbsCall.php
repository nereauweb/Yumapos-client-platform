<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiMbsCall extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_mbs_calls';
	
	protected $fillable = [
		'user_id',
		'operation_id',
		'fields',
		'raw_answer',
		];
		
	public function user(){ 
		return $this->hasOne('App\User','id','user_id'); 
	}
}