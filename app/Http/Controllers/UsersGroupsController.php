<?php

namespace App\Http\Controllers;

use App\Models\UsersGroup;
use App\Models\UsersGroupConfiguration;
use App\Models\ServiceCategory;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\ApiReloadlyOperator;
use App\Models\ApiReloadlyOperatorConfiguration;
use App\Models\ApiReloadlyOperatorConfigurationAmount;
use App\Models\ApiReloadlyOperatorConfigurationLocalAmount;
use App\Models\ApiDingOperator;
use App\Models\ApiDingOperatorConfiguration;
use App\Models\ApiDingOperatorConfigurationAmount;
use App\Models\ApiDingProduct;

use Validator;

class UsersGroupsController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

	/**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'type'                  => 'required',
                'name'                  => 'required|max:127|unique:users_groups',
            ],
            [
                'type.required'       	=> 'tipo richiesto',
                'name.unique'         	=> 'nome già in uso',
                'name.required'       	=> 'nome richiesto',
                'name.max'       		=> 'nome troppo lungo',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
		
		$group = UsersGroup::create([
			'type'             	=> $request->type,
			'name'             	=> $request->name,
			'discount' 			=> $request->discount ?? 0,
			'description'		=> $request->description ? $request->description : "",
			'use_margin'		=> $request->type == 1 ? ($request->margin ? true : false) : true,
		]);
		
		if ($request->hasFile('logo')) {
			$saved_filename = 'logo'.time().'.'.$request->logo->extension();
			$request->logo->storeAs('public',$saved_filename);
			$group->logo = $saved_filename;
			$group->save();
		}		
		
		if ($request->type != 1) {
			foreach ($request->configurations as $target_group_id => $cat_configuration){
				foreach ($cat_configuration as $category_id => $configuration){
					if (isset($configuration['type'])&&$configuration['amount']){
						UsersGroupConfiguration::create([
							'group_id'      	=> $group->id,
							'category_id'   	=> $category_id,
							'target_group_id'   => $target_group_id,
							'type'			=> $configuration['type'],
							'amount'      	=> $configuration['amount'],
						]);
					}
				}
			}
		}

        return redirect()->route('admin.groups.list')->with(['status' => 'success', 'message' => 'Gruppo creato correttamente!']);
    }

	/**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = UsersGroup::find($id);
		$validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:127',
            ],
            [
                'name.unique'         	=> 'nome già in uso',
                'name.required'       	=> 'nome richiesto',
                'name.max'       		=> 'nome troppo lungo',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $group->name 		= $request->input('name');
        $group->description = $request->input('description') ? $request->input('description') : "";
		if ($group->type==1){
			$group->discount	= $request->input('discount');
			$group->use_margin 	= $request->input('margin') ? true : false;
		} else {
			foreach ($request->configurations as $target_group_id => $cat_configuration){
				foreach ($cat_configuration as $category_id => $configuration){
					if (isset($configuration['type'])&&$configuration['amount']){
						UsersGroupConfiguration::updateOrCreate([
							'group_id'      	=> $group->id,
							'category_id'   	=> $category_id,
							'target_group_id'   => $target_group_id,
						], [
							'type'			=> $configuration['type'],
							'amount'      	=> $configuration['amount'],
						]);
					}
				}
			}
		}
		if ($request->input('remove_logo')){
			$group->logo = null;
		}
		if ($request->hasFile('logo')) {
			$saved_filename = 'logo'.time().'.'.$request->logo->extension();
			$request->logo->storeAs('public',$saved_filename);
			$group->logo = $saved_filename;
		}
		$group->save();
		if($request->input('users')){
			if ($group->type==1){
				foreach($request->input('users') as $user_id){
					$user = User::find($user_id);
					if ($user->group_id != $group->id){
						$user->group_id = $group->id;
						$user->save();
					}
				}
			} else {
				foreach($request->input('users') as $user_id){
					$user = User::find($user_id);
					if ($user->agent_group_id != $group->id){
						$user->agent_group_id = $group->id;
						$user->save();
					}
				}
			}
		}
        return back()->with(['status' => 'success', 'message' => 'Gruppo aggiornato con successo']);
	}

	public function delete(Request $request, $id)
    {
		$group = UsersGroup::find($id);
		$group->delete();
		return back()->with('success', 'Gruppo eliminato con successo');
	}

	public function deleted()
    {
		$groups = UsersGroup::onlyTrashed()->get();
        return view('admin/users/groups-deleted', ['groups' => $groups]);
    }

	public function recover(Request $request, $id)
    {
		$group = UsersGroup::withTrashed()->find($id);
		$group->restore();
		return redirect()->route('admin.groups.list')->with(['status' => 'success', 'message' => 'Gruppo ripristinato con successo!']);
	}

    public function list()
    {
		$groups = UsersGroup::all();
        return view('admin/users/groups-list', compact('groups'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public function create()
    {
		return view('admin/users/group-create');
	}

	public function create_agent()
    {
		$target_groups = UsersGroup::where('type',1)->get();
		$categories = ServiceCategory::all();
		return view('admin/users/group-create-agent',compact('target_groups','categories'));
	}


	/**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = UsersGroup::findOrFail($id);
		if ($group->type == 1) {
			$users = User::role('user')->get();
			return view('admin/users/group-edit',compact('group','users'));
		}
		if ($group->type == 2) {
			$users = User::role('sales')->get();
			$target_groups = UsersGroup::where('type',1)->get();
			$categories = ServiceCategory::all();
			return view('admin/users/group-edit-agent',compact('group','users','target_groups','categories'));
		}
    }

	/**
     * Show the resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $group = UsersGroup::findOrFail($id);
        return view('admin/users/group-view',compact('group'));
    }	
	
	public function ping_pricings(){
		$total_ding_configurations = 0;		
		$total_ding_configurations_set = 0;
		$total_ding_configurations_amounts = 0;
		$total_ding_configurations_amounts_set = 0;
		$total_reloadly_configurations = 0;		
		$total_reloadly_configurations_set = 0;
		$total_reloadly_configurations_amounts = 0;
		$total_reloadly_configurations_amounts_set = 0;
		$total_reloadly_configurations_local_amounts = 0;
		$total_reloadly_configurations_local_amounts_set = 0;
		
		$standard_configurations = ApiDingOperatorConfiguration::where('group_id',6)->get();
		foreach($standard_configurations as $standard_configuration){
			$total_ding_configurations++;
			$original_fx = $standard_configuration->original_fx();
			if (!$original_fx) { continue; }
			$standard_fx = $original_fx - ($original_fx * $standard_configuration->fx_delta_percent / 100);
			$new_fx = $standard_fx / 1.25;
			$new_fx_delta = -1 * ((($new_fx - $original_fx)/$original_fx * 100));
			//return redirect()->route('admin.groups.list')->with(['status' => 'success', 'message' => "DEBUG ".$standard_configuration->operator_ProviderCode.": original_fx $original_fx | standard_fx $standard_fx | new_fx $new_fx | new_fx_delta $new_fx_delta	"]);
			$ping_configuration = ApiDingOperatorConfiguration::updateOrCreate(
				[
					'operator_ProviderCode' => $standard_configuration->operator_ProviderCode,
					'group_id' => 12
				],
				[
					'fx_delta_percent' =>  round($new_fx_delta,2),
					'discount_percent' =>  10,
					'enabled' =>  $standard_configuration->enabled,
				]);
			$total_ding_configurations_set++;
			foreach($standard_configuration->amounts as $standard_configuration_amount){
				$total_ding_configurations_amounts++;
				ApiDingOperatorConfigurationAmount::updateOrCreate(
				[
					'parent_id' => $ping_configuration->id,
					'original_amount' => $standard_configuration_amount->original_amount
				],
				[
					'final_amount' => round($standard_configuration_amount->final_amount * 1.25,2),
					'discount' => 10,
					'visible' =>  $standard_configuration_amount->visible,
				]);
				$total_ding_configurations_amounts_set++;
			}
		}
		$standard_reloadly_configurations = ApiReloadlyOperatorConfiguration::where('group_id',6)->get();
		foreach($standard_reloadly_configurations as $standard_reloadly_configuration){	
			$total_reloadly_configurations++;
			$original_fx = $standard_reloadly_configuration->original_fx();
			if (!$original_fx) { continue; }
			$standard_fx = $original_fx - ($original_fx * $standard_reloadly_configuration->fx_delta_percent / 100);
			$new_fx = $standard_fx / 1.25;
			$new_fx_delta = -1 * ((($new_fx - $original_fx)/$original_fx) * 100);
			$ping_reloadly_configuration = ApiReloadlyOperatorConfiguration::updateOrCreate(
				[
					'operator_id' => $standard_reloadly_configuration->operator_id,
					'group_id' => 12
				],
				[
					'fx_delta_percent' => round($new_fx_delta,2),
					'discount_percent' =>  10,
					'enabled' =>  $standard_reloadly_configuration->enabled,
				]);
			$total_reloadly_configurations_set++;
			foreach($standard_reloadly_configuration->amounts as $standard_reloadly_configuration_amount){
				$total_reloadly_configurations_amounts++;				
				ApiReloadlyOperatorConfigurationAmount::updateOrCreate(
				[
					'parent_id' => $ping_reloadly_configuration->id,
					'original_amount' => $standard_reloadly_configuration_amount->original_amount
				],
				[
					'final_amount' => round($standard_reloadly_configuration_amount->final_amount * 1.25,2),
					'discount' => 10,
					'visible' =>  $standard_reloadly_configuration_amount->visible,
				]);				
				$total_reloadly_configurations_amounts_set++;	
			}
			foreach($standard_reloadly_configuration->local_amounts as $standard_reloadly_configuration_local_amount){		
				$total_reloadly_configurations_local_amounts++;				
				ApiReloadlyOperatorConfigurationAmount::updateOrCreate(
				[
					'parent_id' => $ping_reloadly_configuration->id,
					'original_amount' => $standard_reloadly_configuration_local_amount->original_amount
				],
				[
					'final_amount' => round($standard_reloadly_configuration_local_amount->final_amount * 1.25,2),
					'discount' => 10,
					'visible' =>  $standard_reloadly_configuration_local_amount->visible,
				]);
				$total_reloadly_configurations_local_amounts_set++;	
			}
		}
		return redirect()->route('admin.groups.list')->with(['status' => 'success', 'message' => "Pricings Ping aggiornati:
		
		ding_configurations $total_ding_configurations_set / $total_ding_configurations ; 		
		
		ding_configurations_amounts $total_ding_configurations_amounts_set /$total_ding_configurations_amounts ; 
		
		reloadly_configurations $total_reloadly_configurations_set / $total_reloadly_configurations ; 		
		
		reloadly_configurations_amounts $total_reloadly_configurations_amounts_set / $total_reloadly_configurations_amounts ; 
		
		reloadly_configurations_local_amounts $total_reloadly_configurations_local_amounts_set / $total_reloadly_configurations_local_amounts ; 
		
		"]);
	}
	
}
