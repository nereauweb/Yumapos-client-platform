<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProviderController extends Controller
{
    private $regions;

    public function __construct()
    {
        $this->regions = ['Abruzzo' => 'Abruzzo', 'Basilicata' => 'Basilicata', 'Calabria' => 'Calabria', 'Campania' => 'Campania', 'Emilia-Romagna' => 'Emilia-Romagna', 'Friuli Venezia Giulia' => 'Friuli Venezia Giulia', 'Lazio' => 'Lazio', 'Liguria' => 'Liguria', 'Lombardia' => 'Lombardia', 'Marche' => 'Marche', 'Molise' => 'Molise', 'Piemonte' => 'Piemonte', 'Puglia' => 'Puglia', 'Sardegna' => 'Sardegna', 'Sicilia' => 'Sicilia', 'Toscana' => 'Toscana'];
    }

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
        $regions = $this->regions;
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
        $data = $this->validateProviderForm($request);

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
        $regions = $this->regions;
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
        $provider = Provider::findOrFail($id);
        $data = $this->validateProviderForm($request);
        $referentsData = $this->validateReferentsForm($request);
        try {
            DB::beginTransaction();
            $provider->update($data);
            foreach ($referentsData as $referent) {
                $provider->referents->find($referent['id'])->update($referent);
            }
            DB::commit();
            return redirect()->route('admin.providers.index')->with(['status' => 'success', 'message' => 'Successfully updated the provider']);
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.providers.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        try {
            $provider->delete();
            return redirect()->route('admin.providers.index')->with(['status' => 'success', 'message' => 'Successfully added to trash bin the provider']);
        } catch (\Exception $e) {
            return redirect()->route('admin.providers.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function trash() :View
    {
        $providers = Provider::onlyTrashed()->paginate(10);
        return view('admin.providers.trash', compact('providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $provider = Provider::withTrashed()->findOrFail($id);
        try {
            $provider->restore();
            return redirect()->route('admin.providers.index')->with(['status' => 'success', 'message' => 'Successfully restored the provider from trash']);
        } catch (QueryException $e) {
            return redirect()->route('admin.providers.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    //    helpers
    private function validateProviderForm(Request $request)
    {
        return $request->validate([
            'company_name' => 'required',
            'legal_seat' => '',
            'legal_seat_address' => '',
            'legal_seat_zip' => '',
            'legal_seat_city' => '',
            'legal_seat_region' => '',
            'legal_seat_country' => '',
            'operative_seat' => '',
            'operative_seat_address' => '',
            'operative_seat_zip' => '',
            'operative_seat_city' => '',
            'operative_seat_region' => '',
            'operative_seat_country' => '',
            'vat' => '',
            'tax_unique_code' => '',
            'pec' => '',
            'email' => '',
            'phone' => '',
            'website' => '',
            'support_email' => 'required'
        ]);
    }

    private function validateReferentsForm(Request $request)
    {
        $data = [];
        $request->validate([
            'referents.*.surname' => [
                'required'
            ],
            'referents.*.role' => [
                'required',
            ]
        ]);
        foreach($request->referents as $key => $referent) {
            $data[$key] = $referent;
            $data[$key]['id'] = $key;
        }

        return $data;
    }
}
