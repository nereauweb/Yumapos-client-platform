<?php

namespace App\Http\Controllers;

use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorConfiguration;
use App\Models\ApiReloadlyOperatorConfigurationAmount;
use App\Models\ApiReloadlyOperatorConfigurationLocalAmount;
use App\Models\UsersGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ReloadlyController extends Controller
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
		$operators = ApiReloadlyOperator::all();
        return view('admin/reloadly/list', compact('operators') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_local($id)  //local amounts edit
    {
		$operator = ApiReloadlyOperator::find($id);
		app('App\Http\Controllers\ApiReloadlyController')->save_operator($operator->operatorId);
		$operator = ApiReloadlyOperator::find($id);
		$groups = UsersGroup::all();
		$configurations = ApiReloadlyOperatorConfiguration::where('operator_id');
		return view('admin/reloadly/edit-local', compact('operator','groups','configurations') );        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_local(Request $request,$id) // local amounts update
    {
		$operator = ApiReloadlyOperator::find($id);
		$groups = $request->input('group');
		if($operator->denominationType=="RANGE"){
			foreach($groups as $group_id => $group_data) {
				ApiReloadlyOperatorConfiguration::updateOrCreate(
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
				$configuration = ApiReloadlyOperatorConfiguration::updateOrCreate(
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
					ApiReloadlyOperatorConfigurationLocalAmount::updateOrCreate(
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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
	{
		$operator = ApiReloadlyOperator::find($id);
		app('App\Http\Controllers\ApiReloadlyController')->save_operator($operator->operatorId);
		$operator = ApiReloadlyOperator::find($id);
		return view('admin/reloadly/details', compact('operator') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$operator = ApiReloadlyOperator::find($id);
		app('App\Http\Controllers\ApiReloadlyController')->save_operator($operator->operatorId);
		$operator = ApiReloadlyOperator::find($id);
		$groups = UsersGroup::all();
		$configurations = ApiReloadlyOperatorConfiguration::where('operator_id');
		return view('admin/reloadly/edit', compact('operator','groups','configurations') );
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
		$operator = ApiReloadlyOperator::find($id);
		$groups = $request->input('group');
		if($operator->denominationType=="RANGE"){
			foreach($groups as $group_id => $group_data) {
				ApiReloadlyOperatorConfiguration::updateOrCreate(
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
				$configuration = ApiReloadlyOperatorConfiguration::updateOrCreate(
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
					ApiReloadlyOperatorConfigurationAmount::updateOrCreate(
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
