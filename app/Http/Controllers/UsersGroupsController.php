<?php

namespace App\Http\Controllers;

use App\Models\UsersGroup;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
                'slug'                  => 'required|max:63|unique:users_groups',
            ],
            [
                'type.required'       	=> 'tipo richiesto',
                'name.unique'         	=> 'nome già in uso',
                'name.required'       	=> 'nome richiesto',
                'name.max'       		=> 'nome troppo lungo',
                'slug.unique'         	=> 'slug già in uso',
                'slug.required'       	=> 'slug richiesto',
                'slug.max'       		=> 'slug troppo lungo',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $group = UsersGroup::create([
            'type'             	=> $request->input('type'),
            'name'             	=> $request->input('name'),
            'slug' 				=> $request->input('slug'),
            'discount' 				=> $request->input('discount'),
            'description'		=> $request->input('description') ? $request->input('description') : "",
        ]);

        $group->save();

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
                'slug'                  => 'required|max:63',
            ],
            [
                'name.unique'         	=> 'nome già in uso',
                'name.required'       	=> 'nome richiesto',
                'name.max'       		=> 'nome troppo lungo',
                'slug.unique'         	=> 'slug già in uso',
                'slug.required'       	=> 'slug richiesto',
                'slug.max'       		=> 'slug troppo lungo',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $group->name 		= $request->input('name');
        $group->slug 		= $request->input('slug');
        $group->discount	= $request->input('discount');
        $group->description = $request->input('description') ? $request->input('description') : "";

		$group->save();

		if($request->input('users')){
			foreach($request->input('users') as $user_id){
				$user = User::find($user_id);
				if ($user->group_id != $group->id){
					$user->group_id = $group->id;
					$user->save();
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
	/*
		$paginationEnabled = true;
		$paginationListSize = 15;
        if ($paginationEnabled) {
            $providers = $providers = DB::table('providers')->paginate($paginationListSize);
        } else {

            $providers = DB::table('providers')->get();
        }
	*/
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
		return view('admin/users/group-create-agent');
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
			$users = User::whereHas("roles", function($q){ $q->where("name", "user"); })->get();
		}
		if ($group->type == 2) {
			$users = User::whereHas("roles", function($q){ $q->where("name", "sales"); })->get();
		}
        return view('admin/users/group-edit',compact('group','users'));
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
}
