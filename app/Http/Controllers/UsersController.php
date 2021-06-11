<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Mail\ConfirmationMail;
use App\Mail\UpdatedPasswordMail;
use Illuminate\Http\Request;
use App\User;
use App\Models\UserCompanyData;
use App\Models\UsersGroup;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HasEventBus;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $you = auth()->user();
        $users = User::all();
        $groups = UsersGroup::all();
        return view('dashboard.admin.usersList', compact('users', 'you', 'groups'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $you = auth()->user();
        $users = User::onlyTrashed()->get();
        return view('admin.users.deleted', compact('users', 'you'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.admin.userShow', compact( 'user' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$users = User::all();
		$roles = Role::all();
		$agentGroups = UsersGroup::where('type', 2)->get();
		$userGroups = UsersGroup::where('type', 1)->get();
        $user = User::find($id);
        return view('admin.users.edit', compact('users','roles','user', 'agentGroups', 'userGroups'));
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
        $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256',
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');

		$user->parent_id = $request->input('parent') ? $request->input('parent') : 0;
		if ($request->input('parent_percent')){
			$user->parent_percent 	= $request->input('parent_percent');
		}
		if ($request->input('plafond')){
			$user->plafond 	= $request->input('plafond');
		}
		if ($request->input('debt_limit')){
			$user->debt_limit 	= $request->input('debt_limit');
		}

		if ($request->input('password')) {
		    if ($request->input('password') == $request->input('password_confirmation')) {
                $user->password = Hash::make($request->input('password'));
                Mail::to($user->email)->send(new UpdatedPasswordMail($user, $request->input('password')));
            } else {
		        return back()->with(['status' => 'error', 'message' => 'user passwords do not match']);
            }
        }

        $user->save();

		$data = [
            'company_name'			=> $request->input('company_name'),
            'legal_seat_address'	=> $request->input('legal_seat_address'),
            'legal_seat_zip'		=> $request->input('legal_seat_zip'),
            'legal_seat_city'		=> $request->input('legal_seat_city'),
            'legal_seat_region'		=> $request->input('legal_seat_region'),
            'legal_seat_country'	=> $request->input('legal_seat_country') ? $request->input('legal_seat_country') : NULL,
            'operative_seat_address'=> $request->input('operative_seat_address'),
            'operative_seat_zip'	=> $request->input('operative_seat_zip'),
            'operative_seat_city'	=> $request->input('operative_seat_city'),
            'operative_seat_region'	=> $request->input('operative_seat_region'),
            'operative_seat_country'=> $request->input('operative_seat_country') ? $request->input('operative_seat_country') : NULL,
            'vat'					=> $request->input('vat'),
            'tax_unique_code'		=> $request->input('tax_unique_code'),
            'vat_percent'			=> $request->input('vat_percent'),
            'witholding_tax_percent'=> $request->input('witholding_tax_percent'),
            'pec'					=> $request->input('pec'),
            'email'					=> $request->input('company_email'),
            'phone'					=> $request->input('phone'),
            'mobile'				=> $request->input('company_mobile'),
            'referent_name'			=> $request->input('referent_name'),
            'referent_surname'		=> $request->input('referent_surname'),
            'referent_mobile'		=> $request->input('referent_mobile'),
            'shop_sign'				=> $request->input('shop_sign'),
        ];

		if ($user->company_data) {
			$user->company_data->update($data);
		} else {
		    $data['user_id'] = $user->id;
			UserCompanyData::create($data);
		}

		if ($user->hasRole('sales') && $request->role == 'user') {
		    $user->removeRole('sales');
		    $user->update([
		       'group_id' => $request->group_id
            ]);
        } else if ($request->role == 'sales') {
			$user->assignRole(['user','sales']);
		    $user->update([
		        'agent_group_id' => $request->agent_group_id,
                'group_id' => $request->group_id
            ]);

		    $user->assignRole('sales');
        } elseif ($request->role == 'user') {
			$user->update([
		       'group_id' => $request->group_id
            ]);
		}

//        $request->session()->flash('message', 'Successfully updated user');
		return redirect('users')->with(['status' => 'success', 'message' => 'Successfully updated user.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return redirect()->route('users.index');
    }

	public function recover($id)
    {
        $user = User::withTrashed()->find($id);
        if($user){
            $user->restore();
        }
        return redirect()->route('users.index');
    }

	public function create(){
		$users = User::all();
		$roles = Role::all();
		$groups = UsersGroup::all();
		$sales = User::role('sales')->get();
		return view('admin.users.create', compact('users','roles','groups', 'sales'));
	}

	public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:255|unique:users',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
                'group_id'              => 'required',
            ],
            [
                'name.unique'         => trans('auth.userNameTaken'),
                'name.required'       => trans('auth.userNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
                'password.required'   => trans('auth.passwordRequired'),
                'password.min'        => trans('auth.PasswordMin'),
                'password.max'        => trans('auth.PasswordMax'),
                'role.required'       => trans('auth.roleRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'email'            => $request->input('email'),
            'email_verified_at'=> date("Y-m-d H:i:s"),
            'menuroles'		   => $request->input('role'),
            'name'             => $request->input('name'),
            'parent_id'        => $request->input('parent') ? $request->input('parent') : 0,
            'password'         => bcrypt($request->input('password')),
            'remember_token'   => Str::random(64),
            'group_id'         => $request->input('group_id')
        ]);

        $user->assignRole($request->input('role'));
        if ($user->hasRole('sales')) {
            $user->agent_group_id = $request->input('agent_group_id');
        }


		$user->company_data()->create([
            'referent_name'	   => $request->input('first_name'),
            'referent_surname' => $request->input('last_name'),
		]);
        $user->save();

		if ($user->hasRole('user')) {
			return redirect('users/'.$user->id.'/edit')->with(['status' => 'success', 'message' => trans('usersmanagement.createSuccess')]);
		}
    }

    public function approve(Request $request, $id)
    {

        $user = User::FindOrFail($id);

        $request->validate([
            'parent_percent' => 'required',
            'group' => 'required'
        ]);

        try {

            $notHashedPassword = Str::random();

            $user->update([
                'state' => 1,
                'group_id' => $request->group,
                'parent_percent' => $request->parent_percent,
                'password' => bcrypt($notHashedPassword),
            ]);


            Mail::to($user->email)->send(new ConfirmationMail($user, $notHashedPassword));

            return back()->with(['status' => 'success', 'message' => 'User approved successfully!']);

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    //    export function
    public function export(Request $request)
    {
        $collection = User::role('user')->join('users_company_data as ucd', 'ucd.user_id', 'users.id')->when($request->stateUserSelected, function ($query) use ($request) {
            if ($request->stateUserSelected == 1) {
                $query->where('users.state', '=', 1);
            } else if ($request->stateUserSelected  == 2) {
                $query->onlyTrashed();
            } else if ($request->stateUserSelected == 3) {
                $query->where('users.state', '=', 0);
            }
        })->when($request->balanceUserSelected, function ($query) use ($request) {
            if ($request->balanceUserSelected == 1) {
                $query->where('users.plafond', '>', 0);
            } else if ($request->balanceUserSelected == 2) {
                $query->where('users.plafond', '<', 0);
            } else if ($request->balanceUserSelected == 3) {
                $query->where('users.plafond', '=', 0);
            }
        })->when($request->roleUserSelected !== 'null' && $request->roleUserSelected, function ($query) use ($request) {
            $query->role($request->roleUserSelected);
        })->when($request->cityUserSelected !== 'null' && $request->cityUserSelected, function ($query) use ($request) {
            $query->where('ucd.legal_seat_city', '=', $request->cityUserSelected);
        })->select('ucd.email', 'ucd.shop_sign', 'ucd.company_name', 'ucd.vat', 'ucd.operative_seat_address', 'ucd.operative_seat_zip', 'ucd.operative_seat_city', 'ucd.phone', 'users.plafond')->get();

        return Excel::download(new UsersExport($collection), 'users.xlsx');
    }

    public function changeRole(User $user)
    {
		request()->validate([
		   'role' => 'required',
		   'group_id' => 'required'
		]);
		$user->group_id = request()->group_id;
		if (request()->role=='user'){
			$user->removeRole('sales');
			$user->agent_group_id = NULL;
		}
		if (request()->role=='sales'){
			request()->validate([
                'agent_group_id' => 'required'
            ]);
			if(!$user->hasRole('sales')){
				$user->assignRole('sales');
			}
			$user->agent_group_id = request()->agent_group_id;
		}
		$user->save();
        return back()->with(['status' => 'success', 'message'=> 'Role and groups updated successfully']);
    }
}
