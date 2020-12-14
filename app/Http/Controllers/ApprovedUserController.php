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
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::findOrFail(auth()->id());

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
