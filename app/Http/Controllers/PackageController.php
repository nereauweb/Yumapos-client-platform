<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceCategory;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PackageController extends Controller
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
        return view('admin/package/categories', compact('categories'));
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
		$services = [];
        return view('admin/package/list', compact('services'));
    }
	
	public function deleted()
    {
		$services = [];
        return view('admin/package/deleted', compact('services'));
    }
	
	public function create()
    {
        return view('admin/package/create', compact(''));
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
		
        return redirect('admin.package.list')->with('success','Service created');
    }
	
}