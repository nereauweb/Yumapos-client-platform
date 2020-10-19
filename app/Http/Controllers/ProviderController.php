<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProviderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index() :View
    {
        $providers = Provider::paginate(10);
        return view('admin.providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() :View
    {
        $regions = ['Abruzzo' => 'Abruzzo', 'Basilicata' => 'Basilicata', 'Calabria' => 'Calabria', 'Campania' => 'Campania', 'Emilia-Romagna' => 'Emilia-Romagna', 'Friuli Venezia Giulia' => 'Friuli Venezia Giulia', 'Lazio' => 'Lazio', 'Liguria' => 'Liguria', 'Lombardia' => 'Lombardia', 'Marche' => 'Marche', 'Molise' => 'Molise', 'Piemonte' => 'Piemonte', 'Puglia' => 'Puglia', 'Sardegna' => 'Sardegna', 'Sicilia' => 'Sicilia', 'Toscana' => 'Toscana'];
        return view('admin.providers.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required',
            'legal_seat' => 'required',
            'legal_seat_address' => 'required',
            'legal_seat_zip' => 'required',
            'legal_seat_city' => 'required',
            'legal_seat_region' => 'required',
            'legal_seat_country' => 'required',
            'operative_seat' => 'required',
            'operative_seat_address' => 'required',
            'operative_seat_zip' => 'required',
            'operative_seat_city' => 'required',
            'operative_seat_region' => 'required',
            'operative_seat_country' => 'required',
            'vat' => 'required',
            'tax_unique_code' => 'required',
            'pec' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'website' => 'required',
            'support_email' => 'required'
        ]);

        try {
            Provider::create($data);
            return redirect()->route('admin.providers.index')->with(['status' => 'success', 'message' => 'Successfully registered the provider']);
        } catch (QueryException $e) {
            return redirect()->route('admin.providers.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id) :View
    {
        $provider = Provider::findOrFail($id);
        $regions = ['Abruzzo' => 'Abruzzo', 'Basilicata' => 'Basilicata', 'Calabria' => 'Calabria', 'Campania' => 'Campania', 'Emilia-Romagna' => 'Emilia-Romagna', 'Friuli Venezia Giulia' => 'Friuli Venezia Giulia', 'Lazio' => 'Lazio', 'Liguria' => 'Liguria', 'Lombardia' => 'Lombardia', 'Marche' => 'Marche', 'Molise' => 'Molise', 'Piemonte' => 'Piemonte', 'Puglia' => 'Puglia', 'Sardegna' => 'Sardegna', 'Sicilia' => 'Sicilia', 'Toscana' => 'Toscana'];
        return view('admin.providers.edit', compact('provider', 'regions'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
