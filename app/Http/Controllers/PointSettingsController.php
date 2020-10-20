<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PointSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        return view('users/settings/account' );
    }

	public function update(Request $request)
    {

		$validator = Validator::make($request->all(),
            [
                'gain'          => 'required|numeric',
            ],
            [
                'gain.required' => 'Valore richiesto',
                'gain.numeric'  => 'Formato non valido',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $configuration = Auth::user()->configuration;
		if (!$configuration){
			Auth::user()->configuration()->create(['default_gain' => $request->input('gain') ]);
		} else {
			$configuration->default_gain = $request->input('gain');
			$configuration->save();
		}

        return back()->with(['status' => 'success', 'success' => 'Impostazione aggiornata con successo']);
	}

}
