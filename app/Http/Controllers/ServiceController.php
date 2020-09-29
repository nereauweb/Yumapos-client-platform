<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserCompanyData;
use App\Models\UsersGroup;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $you = auth()->user();
        $users = User::all();
        return view('dashboard.admin.usersList', compact('users', 'you'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $you = auth()->user();
        $users = User::onlyTrashed()->get();
        return view('admin.users.deleted', compact('users', 'you'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.admin.userShow', compact( 'user' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$users = User::all();
		$roles = Role::all();
        $user = User::find($id);
        return view('admin.users.edit', compact('users','roles','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256'
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
		
		$user->parent_id = $request->input('parent') ? $request->input('parent') : 0;
		if ($request->input('parent_percent')){
			$user->parent_percent 	= $request->input('parent_percent');
		}
		if ($request->input('plafond')){
			$user->plafond 	= $request->input('plafond');
		}
		if ($request->input('debt_limit')){
			$user->debt_limit 	= $request->input('debt_limit');
		}
		
		$message = '';
		
		if ($request->input('password')&&$request->input('password')==$request->input('password_confirmation')){
			$user->password = bcrypt($request->input('password'));
			$message = 'Password updated.';
		}
		
        $user->save();		
		
		if ($user->company_data) {
			$user->company_data->update([
				'company_name'			=> $request->input('company_name'),
				'legal_seat_address'	=> $request->input('legal_seat_address'),
				'legal_seat_zip'		=> $request->input('legal_seat_zip'),
				'legal_seat_city'		=> $request->input('legal_seat_city'),
				'legal_seat_region'		=> $request->input('legal_seat_region'),
				'legal_seat_country'	=> $request->input('legal_seat_country') ? $request->input('legal_seat_country') : NULL,
				'operative_seat_address'=> $request->input('operative_seat_address'),
				'operative_seat_zip'	=> $request->input('operative_seat_zip'),
				'operative_seat_city'	=> $request->input('operative_seat_city'),
				'operative_seat_region'	=> $request->input('operative_seat_region'),
				'operative_seat_country'=> $request->input('operative_seat_country') ? $request->input('operative_seat_country') : NULL,
				'vat'					=> $request->input('vat'),
				'tax_unique_code'		=> $request->input('tax_unique_code'),
				'vat_percent'			=> $request->input('vat_percent'),
				'witholding_tax_percent'=> $request->input('witholding_tax_percent'),
				'pec'					=> $request->input('pec'),
				'email'					=> $request->input('company_email'),
				'phone'					=> $request->input('phone'),
				'mobile'				=> $request->input('company_mobile'),
				'referent_name'			=> $request->input('referent_name'),
				'referent_surname'		=> $request->input('referent_surname'),
				'referent_mobile'		=> $request->input('referent_mobile'),
				'shop_sign'				=> $request->input('shop_sign'),
			]);
		} else {
			UserCompanyData::create([
				'user_id'				=> $user->id,
				'company_name'			=> $request->input('company_name'),
				'legal_seat_address'	=> $request->input('legal_seat_address'),
				'legal_seat_zip'		=> $request->input('legal_seat_zip'),
				'legal_seat_city'		=> $request->input('legal_seat_city'),
				'legal_seat_region'		=> $request->input('legal_seat_region'),
				'legal_seat_country'	=> $request->input('legal_seat_country') ? $request->input('legal_seat_country') : NULL,
				'operative_seat_address'=> $request->input('operative_seat_address'),
				'operative_seat_zip'	=> $request->input('operative_seat_zip'),
				'operative_seat_city'	=> $request->input('operative_seat_city'),
				'operative_seat_region'	=> $request->input('operative_seat_region'),
				'operative_seat_country'=> $request->input('operative_seat_country') ? $request->input('operative_seat_country') : NULL,
				'vat'					=> $request->input('vat'),
				'tax_unique_code'		=> $request->input('tax_unique_code'),
				'vat_percent'			=> $request->input('vat_percent'),
				'witholding_tax_percent'=> $request->input('witholding_tax_percent'),
				'pec'					=> $request->input('pec'),
				'email'					=> $request->input('company_email'),
				'phone'					=> $request->input('phone'),
				'mobile'				=> $request->input('company_mobile'),
				'referent_name'			=> $request->input('referent_name'),
				'referent_surname'		=> $request->input('referent_surname'),
				'referent_mobile'		=> $request->input('referent_mobile'),
				'shop_sign'				=> $request->input('shop_sign'),
			]);
		}
		
		return redirect('users')->with('success','Successfully updated user. ' . $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }
	
	public function recover($id)
    {
        $user = User::withTrashed()->find($id);
        if($user){
            $user->restore();
        }
        return redirect()->route('users.index');
    }
	
	public function create(){
		$users = User::all();
		$roles = Role::all();
		$groups = UsersGroup::all();
		return view('admin.users.create', compact('users','roles','groups'));
	}
	
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:255|unique:users',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
            ],
            [
                'name.unique'         => trans('auth.userNameTaken'),
                'name.required'       => trans('auth.userNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
                'password.required'   => trans('auth.passwordRequired'),
                'password.min'        => trans('auth.PasswordMin'),
                'password.max'        => trans('auth.PasswordMax'),
                'role.required'       => trans('auth.roleRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email'            => $request->input('email'),
            'email_verified_at'=> date("Y-m-d H:i:s"),
            'menuroles'		   => $request->input('role'),
            'name'             => $request->input('name'),
            'parent_id'        => $request->input('parent') ? $request->input('parent') : 0,
            'password'         => bcrypt($request->input('password')),
            'remember_token'   => Str::random(64),
        ]);

        $user->assignRole($request->input('role'));
		
		if($request->input('group')!=0){
			$user->group_id = $request->input('group');
		}
		
		$user->company_data()->create([
            'referent_name'	   => $request->input('first_name'),
            'referent_surname' => $request->input('last_name'),		
		]);
        $user->save();
		
		if ($user->hasRole('user')) { 
			return redirect('users/'.$user->id.'/edit')->with('success', trans('usersmanagement.createSuccess'));
		}
    }
}
