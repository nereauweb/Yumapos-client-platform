<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';
	
	protected $fillable = [
		'date',
		'user_id',
		'amount',
		'details',
		'approved',
		];
	
	public function user() {
		return $this->hasOne('App\User','id','user_id');
    }
	
}