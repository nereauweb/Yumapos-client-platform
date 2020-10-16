<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
	
	public function impersonate($user_id){
		if (\Auth::user()->hasrole('admin')){			
			\Auth::loginUsingId($user_id, true);
			return redirect()->route('index')->with('success', 'User identity changed');
		}
		return back()->withError('Not authorized');
	}
}
