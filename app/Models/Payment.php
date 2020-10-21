<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentFile;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
		'provider_id',
		'amount',
		'details',
		'approved',
		'type',
        'update_balance'
		];

	public function user() {
		return $this->hasOne('App\User','id','user_id');
	}

	public function provider() {
		return $this->hasOne(Provider::class,'id','provider_id');
	}

	public function userOrProvider() {
		return $this->type == 3 ? $this->provider() : $this->user();
	}

	public function isProvider()
    {
        return $this->type === 3;
    }

	public function documents() : HasMany
	{
		return $this->hasMany(PaymentFile::class, 'payment_id', 'id');
	}

}
