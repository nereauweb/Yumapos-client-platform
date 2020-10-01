<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApprovedUserController extends Controller
{

    public function __construct() {
        $this->middleware('role:user');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::findOrFail(auth()->id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with(['password_err' => 'Wrong current password!']);
        } else {
            try {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);

                return back()->with(['status' => 'success', 'message' => 'password changed']);

            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
