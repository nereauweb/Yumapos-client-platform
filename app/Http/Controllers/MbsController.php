<?php

namespace App\Http\Controllers;

use App\Models\ApiMbsProduct;
use App\Models\ApiMbsConfiguration;
use App\Models\UsersGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class MbsController extends Controller
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
    public function index()
    {
		$products = ApiMbsProduct::all();
        return view('admin/mbs/list', compact('products') );
    }
	
	public function edit($id)
    {
		$product = ApiMbsProduct::find($id);
		$groups = UsersGroup::all();
		return view('admin/mbs/edit', compact('product','groups') );        
    }
	
	public function update(Request $request,$id)
    {
		$product = ApiMbsProduct::find($id);
		$groups = $request->input('group');
			foreach($groups as $group_id => $group_data) {				
				$configuration = ApiMbsConfiguration::updateOrCreate(
					[ 
						'product_id' => $product->id,
						'group_id' => $group_id,
					],
					[
						'percent' => $group_data['percent'],
					]
				);
			}	
		return 'Done.';
    }
	
}