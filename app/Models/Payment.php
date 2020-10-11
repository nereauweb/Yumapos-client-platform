<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentFile;

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
		'type'
		];
	
	public function user() {
		return $this->hasOne('App\User','id','user_id');
	}
	
	public function document() : HasOne
	{
		return $this->hasOne(PaymentFile::class, 'payment_id', 'id');
	}
	
}