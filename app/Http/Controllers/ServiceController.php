<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;

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
        return view('admin/service/categories', compact('categories'));
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
	
	public function index()
    {
		$services = Service::all();
        return view('admin/service/list', compact('services'));
    }
	
	public function deleted()
    {
		$services = Service::onlyTrashed()->get();
        return view('admin/service/deleted', compact('services'));
    }
	
	public function create()
    {
		$categories = ServiceCategory::pluck('name','id');		
        return view('admin/service/create', compact('categories'));
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
	
}