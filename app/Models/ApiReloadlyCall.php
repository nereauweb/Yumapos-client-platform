<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ApiReloadlyCall extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_reloadly_calls';
	
	protected $fillable = [		
		'user_id',
		'type',
		'path',
		'parameters',
		'log',
		'raw_answer',
		];
		
	public function user(){ 
		return $this->hasOne('App\User','id','user_id'); 
	}
}