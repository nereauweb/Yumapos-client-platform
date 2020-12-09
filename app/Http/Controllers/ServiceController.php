<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceCountry;
use App\Models\ServiceOperator;
use App\Models\ApiDingOperator;
use App\Models\ApiReloadlyOperator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ServiceController extends Controller
{

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
    public function categories()
    {
		$categories = ServiceCategory::all();
		$countries = ServiceCountry::orderBy('name')->pluck('name','id');
		$operators = ServiceOperator::orderBy('name')->pluck('name','id');
        return view('admin/service/categories', compact('categories','countries','operators'));
    }

	public function category_create(Request $request) {

        $validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:127',
            ],
            [
                'name.required'       	=> 'nome richiesto',
                'name.max'       		=> 'nome troppo lungo'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category = ServiceCategory::create([
            'name' => $request->input('name'),
        ]);

		return back()->with('success','Category created');
    }

	public function category_data($id){
		$category = ServiceCategory::findOrFail($id);
		$return = [
			'country_list_type' => $category->country_list_type,
			'countries' => $category->countries()->pluck('service_countries.id'),
			'operator_list_type' => $category->country_list_type,
			'operators' => $category->operators()->pluck('service_operators.id'),
		];
		return response()->json($return);
	}

	public function categories_update(Request $request) {
		foreach ($request->input('categories') as $id => $input) {
			$category = ServiceCategory::findOrFail($id);
			if ($input['delete']==1){
				$category->delete();
			} else {
				$category->name = $input['name'];
				$category->save();
			}
		}
		return back()->with('success','Categories updated');
	}

	public function category_configuration_update(Request $request, $id) {
		$category = ServiceCategory::findOrFail($id);
		$category->country_list_type = $request->input('country_list_type');
		$category->operator_list_type = $request->input('operator_list_type');
		$category->save();
		$category->countries()->sync(json_decode($request->input('countries')));
		$category->operators()->sync(json_decode($request->input('operators')));
		return 'Done';
	}

	public function index()
    {
        return view('admin/service/list');
    }

	public function deleted()
    {
		$services = Service::onlyTrashed()->get();
        return view('admin/service/deleted', compact('services'));
    }

	public function create()
    {
		$categories = ServiceCategory::orderBy('name')->pluck('name','id');
		$operators = ServiceOperator::orderBy('name')->pluck('name','id');
		$countries = ServiceCountry::orderBy('name')->pluck('name','id');
        return view('admin/service/create', compact('categories','operators','countries'));
    }

	public function store()
    {
		$validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:127',
            ],
            [
                'name.required'       	=> 'nome richiesto',
                'name.max'       		=> 'nome troppo lungo'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $service = Service::create([
            'name'      	=> $request->input('name'),
            'category_id'	=> $request->input('category_id'),
            'description'  	=> $request->input('description'),
        ]);

        return redirect('admin.service.list')->with('success','Service created');
    }

	public function edit(Request $request, $id)
    {
		$service::find($id);
		$categories = ServiceCategory::pluck('name','id');
        return view('admin/service/create', compact('categories','service'));
    }

	public function update()
    {
		$validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:127',
            ],
            [
                'name.required'       	=> 'nome richiesto',
                'name.max'       		=> 'nome troppo lungo'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $service = Service::create([
            'name'      	=> $request->input('name'),
            'category_id'	=> $request->input('category_id'),
            'description'  	=> $request->input('description'),
        ]);

        return redirect('admin.service.list')->with('success','Service created');
    }


	public function set_master(Request $request, $id){
		$service_operator = ServiceOperator::find($id);
		if (!$service_operator){
			return 'Service operator ID '.$request->input('operator').' not found';
		}
		$new_master = $request->input('master');
		if ($service_operator->$new_master){
			$service_operator->master = $new_master;
			$service_operator->save();
			return 'OK';
		} else {
			return 'Chosen provider not present';
		}
	}

	public function associate(Request $request, $id){
		$service_operator = ServiceOperator::find($id);
		if (!$service_operator){
			return 'Target service operator ID '.$request->input('operator').' not found';
		}
		if ($request->input('provider')=='ding'){
			$old_service_operator = ServiceOperator::where('ding_ProviderCode',$request->input('identifier'))->first();
		}
		if ($request->input('provider')=='reloadly'){
			$old_service_operator = ServiceOperator::where('reloadly_operatorId',$request->input('identifier'))->first();
		}
		if (!isset($old_service_operator)||!$old_service_operator){
			return 'Source service operator '.$request->input('provider').' '.$request->input('identifier').' not found';
		}
		if ($request->input('provider')=='ding'){
			$service_operator->ding_ProviderCode = $request->input('identifier');
		}
		if ($request->input('provider')=='reloadly'){
			$service_operator->reloadly_operatorId = $request->input('identifier');
		}
		$service_operator->save();
		$old_service_operator->delete();
		return 'OK';
	}

}
