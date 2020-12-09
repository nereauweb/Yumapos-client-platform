<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::guest()) {
			return redirect('login');
		}
        if (\Auth::User() && \Auth()->user()->hasRole('admin')) {
			return $this->admin();
		}
		return $this->user();
    }

	public function admin(){

		/* manual ad hoc run to adjust agent credit (only good before any payment has been made)
		$sales = User::role('sales')->get();
		foreach ($sales as $agent){
			$agent->credit = DB::table('agent_operations')->where('user_id',$agent->id)->sum('commission');
			$agent->save();
		}
		*/

		$paymentsCount = Payment::where('approved', 0)->count();
		$paymentsPending = Payment::where('approved', 0)->limit(3)->orderBy('created_at', 'desc')->get();

		$paymentsData = [
			'totals' => $paymentsCount,
			'pending' => $paymentsPending,
		];

		$usersCount = User::where('state', 0)->count();
		$usersPending = User::where('state', 0)->limit(3)->orderBy('created_at', 'desc')->get();

		$usersData = [
			'totals' => $usersCount,
			'pending' => $usersPending
		];

		$users = User::orderBy('state', 'asc')->paginate(10, ['*'], 'users');

		$reloadly_balance_cache = Cache::get('reloadly_cache_balance');
		$ding_balance_cache = Cache::get('ding_cache_balance');

		return view('welcome', compact( 'paymentsData', 'usersData', 'reloadly_balance_cache', 'ding_balance_cache'));
	}

	public function user(){
		return view('welcome');
	}

}
