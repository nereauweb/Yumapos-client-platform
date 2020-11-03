<?php

namespace App;

use App\Models\Payment;
use App\Models\ServiceOperation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'parent_id', 'parent_percent', 'plafond', 'debt_limit', 'group_id', 'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $attributes = [
        'menuroles' => 'user',
    ];

	public function referent() {
		return $this->hasOne('App\Models\User','id','parent_id');
    }

	public function referenced() {
		return $this->hasMany('App\User','parent_id','id');
    }

	public function company_data() {
		return $this->hasOne('App\Models\UserCompanyData','user_id','id');
    }

	public function group() {
		return $this->hasOne('App\Models\UsersGroup','id','group_id');
    }

	public function configuration() {
		return $this->hasOne('App\Models\UserConfiguration','user_id');
    }

    public function payments() :HasMany
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function serviceOperations() :HasMany
    {
        return $this->hasMany(ServiceOperation::class, 'user_id', 'id');
    }

	public function impersonate($user_id){
		if (\Auth::user()->hasrole('admin')){
			\Auth::loginUsingId($user_id, true);
			return redirect()->route('index')->with('success', 'User identity changed');
		}
		return back()->withError('Not authorized');
	}

	public function adminAccessServices($time)
    {
        if (auth()->user()->hasRole('admin')) {
            if ($time == 'day') {
                return ServiceOperation::orderBy('created_at', 'desc')->whereDate('created_at','2020-08-11')->limit(20)->get();
            } elseif ($time = 'yesterday') {
                return ServiceOperation::orderBy('created_at', 'desc')->whereDate('created_at','2020-08-10')->limit(20)->get();
            } else {
                return ServiceOperation::orderBy('created_at', 'desc')->whereDate('created_at','2020-08-11')->limit(20)->get();
            }
        }
    }
}
