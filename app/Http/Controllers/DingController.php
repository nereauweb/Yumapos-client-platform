<?php

namespace App\Http\Controllers;

use App\Models\ApiDingOperator;
use App\Models\ApiDingProduct;
use App\Models\UsersGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DingController extends Controller
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
		$products = ApiDingProduct::all();
        return view('admin/ding/list', compact('products') );
    }

    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
	{
		$operator = ApiDingOperator::find($id);
		return view('admin/ding/details', compact('operator') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$operator = ApiDingOperator::find($id);
		$groups = UsersGroup::where('type',1)->get();
		return view('admin/ding/edit', compact('operator','groups','id') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuLangList  $menuLangList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
		$operator = ApiDingOperator::find($id);
		$groups = $request->input('group');
		if($operator->denominationType=="RANGE"){
			foreach($groups as $group_id => $group_data) {
				ApiDingOperatorConfiguration::updateOrCreate(
					[ 
						'operator_id' => $operator->operatorId,
						'group_id' => $group_id,
					],
					[
						'fx_delta_percent' => $group_data['fx_delta'],
						'discount_percent' => $group_data['discount'],
						'enabled' => $group_data['enabled'],
					]
				);
			}
		}
		if($operator->denominationType=="FIXED"){
			foreach($groups as $group_id => $group_data) {				
				$configuration = ApiDingOperatorConfiguration::updateOrCreate(
					[ 
						'operator_id' => $operator->operatorId,
						'group_id' => $group_id,
					],
					[
						'enabled' => $group_data['enabled'],
					]
				);
				unset($group_data['enabled']);
				foreach($group_data as $original_amount => $amount_data) {
					ApiDingOperatorConfigurationAmount::updateOrCreate(
						[ 
							'parent_id' => $configuration->id,
							'original_amount' => $original_amount,
						],
						[
							'final_amount' => $amount_data['amount'],
							'discount' => $amount_data['discount'],
							'visible' => isset($amount_data['visible']) && $amount_data['visible'] != '' ? $amount_data['visible'] : 1,
						]
					);
				}
			}			
		}
		return 'Done.';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuLangList  $menuLangList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
		
    }
}
