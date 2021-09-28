<?php

namespace App;

use App\Models\ApiReloadlyOperator;
use App\Models\Payment;
use App\Models\ServiceOperation;
use App\Models\UsersGroupConfiguration;
use Carbon\Carbon;
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
        'name', 'email', 'password', 'parent_id', 'parent_percent', 'plafond', 'debt_limit', 'group_id', 'agent_group_id', 'state', 'credit','api_token'
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
		if ($this->parent_id==0){ return false; }
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

	public function agent_group() {
		return $this->hasOne('App\Models\UsersGroup','id','agent_group_id');
    }
	
	public function agent_commission($target_group_id,$category_id){
		return UsersGroupConfiguration::where('group_id',$this->agent_group_id)
			->where('target_group_id',$target_group_id)
			->where('category_id',$category_id)
			->first();
	}

	public function configuration() {
		return $this->hasOne('App\Models\UserConfiguration','user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function serviceOperations()
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
            $month = Carbon::now()->month;
            $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
            $day = Carbon::today();
            $yesterday = Carbon::yesterday();

            if ($time == 'day') {
                return ServiceOperation::orderBy('created_at', 'desc')->whereDate('created_at', $day)->limit(10)->get();
            } elseif ($time == 'yesterday') {
                return ServiceOperation::orderBy('created_at', 'desc')->whereDate('created_at', $yesterday)->limit(10)->get();
            } else if ($time == 'week') {
                return ServiceOperation::orderBy('created_at', 'desc')->whereBetween('created_at', $week)->limit(10)->get();
            } else {
                return ServiceOperation::orderBy('created_at', 'desc')->whereMonth('created_at', $month)->limit(10)->get();
            }
        }
    }

    public function accessServices($time)
    {
        $month = Carbon::now()->month;
        $week = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $day = Carbon::today();
        $yesterday = Carbon::yesterday();

        if ($time == 'day') {
            return ServiceOperation::where('user_id', auth()->id())->orderBy('created_at', 'desc')->whereDate('created_at', $day)->limit(10)->get();
        } elseif ($time == 'yesterday') {
            return ServiceOperation::where('user_id', auth()->id())->orderBy('created_at', 'desc')->whereDate('created_at', $yesterday)->limit(10)->get();
        } else if ($time == 'week') {
            return ServiceOperation::where('user_id', auth()->id())->orderBy('created_at', 'desc')->whereBetween('created_at', $week)->limit(10)->get();
        } else {
            return ServiceOperation::where('user_id', auth()->id())->orderBy('created_at', 'desc')->whereMonth('created_at', $month)->limit(10)->get();
        }
    }
	
	public function generateToken()
    {
        $this->api_token = \Str::random(60);
        $this->save();

        return $this->api_token;
    }
	
	public function logo($light = false){
		if (!$this->group){
			return $light ? '/img/yuma.png' : '/img/yuma.png';
		}		
		if (!$this->group->logo){
			return $light ? '/img/yuma.png' : '/img/yuma.png';
		}
		return '/files/'.$this->group->logo;
	}
	
	public function tickets_counters($switch = false){
		if ($switch=='submitted'){
			return ServiceOperation::where('user_id',$this->id)->whereNotNull('report_status')->count();
		} 
		if ($switch=='confirmed'){
			return ServiceOperation::where('user_id',$this->id)->where('report_status','reported')->count(); 
		} 
		if ($switch=='answered'){
			return ServiceOperation::where('user_id',$this->id)->whereNotNull('report_status')->where('report_status','!=','reported')->where('updated_at','>',date("Y-m-d H:i:s", strtotime('-7 days')))->count();
		} 
		$submitted = ServiceOperation::where('user_id',$this->id)->whereNotNull('report_status')->count(); 
		$confirmed = ServiceOperation::where('user_id',$this->id)->where('report_status','reported')->count(); 
		$answered = ServiceOperation::where('user_id',$this->id)->whereNotNull('report_status')->where('report_status','!=','reported')->where('created_at','>',date("Y-m-d H:i:s", strtotime('-7 days')))->count();
		return [
			'submitted' => $submitted,
			'confirmed' => $confirmed,
			'answered' => $answered,
		];
	}
	
}
