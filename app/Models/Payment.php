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
		'target_id',
		'amount',
		'details',
		'approved',
		'type',
        'update_balance',
        'update_credit'
		];
	
	public $types = [
		1 => 'user to platform',
		2 => 'platform to user',
		3 => 'platoform to provider',
		4 => 'user to user transfer',
	];
	
	public $types_ita = [
		1 => 'utente a piattaforma',
		2 => 'piattaforma a utente',
		3 => 'piattaforma a fornitore',
		4 => 'trasferimento da utente a utente',
	];
	
	public $types_to_user = [
		1 => 'to platform',
		2 => 'platform to you',
		3 => 'platoform to provider',
		4 => 'transfer from user to you',
	];
	
	public $types_ita_to_user = [
		1 => 'a piattaforma',
		2 => 'piattaforma a te',
		3 => 'piattaforma a fornitore',
		4 => 'trasferimento da utente a te',
	];
	
	public function type($ita = false, $to_user = false, $is_agent = false){
		if ($is_agent && $this->type == 4){
			return $ita ? ('trasferimento a utente ' . $this->target->name) : ('transfer to user ' . $this->target->name);
		}
		if ($ita){
			$array = $to_user ? $this->types_ita_to_user : $this->types_ita;
		} else {
			$array = $to_user ? $this->types_to_user : $this->types;			
		}
		return $to_user ? str_replace("da utente", "da utente " . $this->user->name, $array[$this->type]) : $array[$this->type];
	}

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

	public function target() {
		return $this->hasOne('App\User','id','target_id');
	}

	public function documents()
	{
		return $this->hasMany(PaymentFile::class, 'payment_id', 'id');
	}

}
