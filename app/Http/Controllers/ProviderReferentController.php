<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderReferent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProviderReferentController extends Controller
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
        $referents = ProviderReferent::paginate(10);
        return view('admin.referents.index', compact('referents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() :View
    {
        $regions = $this->regions;
        $providers = Provider::all();
        return view('admin.referents.create', compact('regions', 'providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateReferentForm($request);

        try {
            ProviderReferent::create($data);
            return redirect()->route('admin.referents.index')->with(['status' => 'success', 'message' => 'Successfully registered the referent']);
        } catch (QueryException $e) {
            return redirect()->route('admin.referents.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id) :View
    {
        $referent = ProviderReferent::findOrFail($id);
        $regions = $this->regions;
        return view('admin.referents.edit', compact('referent', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $referent = ProviderReferent::findOrFail($id);
        $data = $this->validateReferentForm($request);
        $providerData = $this->validateProviderForm($request);
        try {
            DB::beginTransaction();
            $referent->update($data);
            $referent->provider()->update($providerData);
            DB::commit();
            return redirect()->route('admin.referents.index')->with(['status' => 'success', 'message' => 'Successfully updated the referent']);
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.referents.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
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
        $referent = ProviderReferent::findOrFail($id);
        try {
            $referent->delete();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Successfully added to trash bin the referent']);
        } catch (\Exception $e) {
            return redirect()->route('admin.referents.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function trash() :View
    {
        $referents = ProviderReferent::onlyTrashed()->paginate(10);
        return view('admin.referents.trash', compact('referents'));
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
        $referent = ProviderReferent::withTrashed()->findOrFail($id);
        try {
            $referent->restore();
            return redirect()->route('admin.providers.index')->with(['status' => 'success', 'message' => 'Successfully restored the referent from trash']);
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

    private function validateReferentForm(Request $request)
    {
        $data = $request->validate([
            'provider_id' => '',
            'name' => '',
            'surname' => 'required',
            'referent_pec' => '',
            'referent_email' => '',
            'referent_phone' => '',
            'referent_mobile' => '',
            'skype' => '',
            'role' => 'required',
        ]);
        $data['pec'] = $data['referent_pec'];
        unset($data['referent_pec']);
        $data['email'] = $data['referent_email'];
        unset($data['referent_email']);
        $data['phone'] = $data['referent_phone'];
        unset($data['referent_phone']);
        $data['mobile'] = $data['referent_mobile'];
        unset($data['referent_mobile']);

        return $data;
    }
}
