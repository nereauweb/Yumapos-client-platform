<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationMail;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function userCreate()
    {
        return view('agents.users.create');
    }

    public function userStore(Request $request)
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
                'parent_id'        => auth()->id(),
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
                'legal_seat_address'	=> $request->legal_seat_address,
				'legal_seat_zip'		=> $request->legal_seat_zip,
				'legal_seat_city'		=> $request->legal_seat_city,
				'legal_seat_region'		=> $request->legal_seat_region,
				'legal_seat_country'	=> NULL,
				'operative_seat_address'=> $request->operative_seat_address,
				'operative_seat_zip'	=> $request->operative_seat_zip,
				'operative_seat_city'	=> $request->operative_seat_city,
				'operative_seat_region'	=> $request->operative_seat_region,
				'operative_seat_country'=> NULL,
				'vat'					=> $request->vat,
				'tax_unique_code'		=> $request->tax_unique_code,
				'vat_percent'			=> $request->vat_percent,
				'witholding_tax_percent'=> $request->witholding_tax_percent,
				'pec'					=> $request->pec,
				'email'					=> $request->company_email,
				'phone'					=> $request->phone,
                'mobile'				=> $request->mobile,
                'referent_mobile'       => $request->company_mobile,
				'shop_sign'				=> $request->shop_sign,
            ]);

            return redirect('/backend')->with(['status' => 'success', 'message' => 'user created successfully, waiting for admin approval..']);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function approve()
    {
        $user = User::findOrFail(request()->user_id);
        request()->validate([
            'parent_percent' => 'required',
            'debt_limit' => 'required',
            'group_id' => 'required',
            'plafond' => 'required|gt:0'
        ]);
        try {
            $notHashedPassword = Str::random(10);
            $user->update([
                'state' => 1,
                'group_id' => request()->group_id,
                'plafond' => request()->plafond,
                'debt_limit' => request()->debt_limit,
                'parent_percent' => request()->parent_percent,
                'password' => bcrypt($notHashedPassword),
            ]);
            Mail::to($user->email)->send(new ConfirmationMail($user, $notHashedPassword));

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
