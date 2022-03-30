<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMail;
use App\Models\ServiceOperator;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {		
		$request->validate(
            [
                'first_name'             => 'required',
                'last_name'              => 'required',
                'email'                  => 'required|email|max:255|unique:users',
                'company_name'           => 'required',
                'vat'                    => 'required',
                'mobile'                 => 'required',
            ],
            [
                'name.required'       => trans('auth.userNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
        ]);

        $identifier = strtolower(Str::random(2));

        try {
            $user = User::create([
                'email'            => $request->email,
                'email_verified_at'=> date("Y-m-d H:i:s"),
                'name'             => $request->first_name.'.'.$request->last_name.'.'.$identifier,
                'parent_id'        => 0,
                'password'         => bcrypt(Str::random()),
                'remember_token'   => Str::random(64),
                'state'            => 0,
                'plafond'          => 0,
                'debt_limit'       => 0
            ]);

            $user->assignRole('user');

            $user->company_data()->create([
                'user_id'               => $user->id,
                'company_name'          => $request->company_name,
                'referent_name'	        => $request->first_name,
                'referent_surname'      => $request->last_name,
				'vat'					=> $request->vat,
            ]);

            return back()->with(['status' => 'success', 'message' => 'user created successfully, wait for admin approval']);

        } catch (\Throwable $th) {
            throw $th;
        }
		
		
    }
}
