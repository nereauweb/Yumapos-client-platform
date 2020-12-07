<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.account.index');
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
        $this->validate($request, [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::findOrFail($id);

        try {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with(['status' => 'success', 'message' => 'password updated']);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
