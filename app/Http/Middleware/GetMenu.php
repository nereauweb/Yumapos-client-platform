<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Menus\GetSidebarMenu;
use App\Models\Menulist;
use App\Models\MenuLangList;
use App\Models\RoleHierarchy;
use App;
use Spatie\Permission\Models\Role;
use App\Models\ServiceCategory;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
		$extra = '';
        if (Auth::check()){
            $role = 'guest';
            //$role =  Auth::user()->menuroles;
            $userRoles = Auth::user()->getRoleNames();
            //$userRoles = $userRoles['items'];
            $roleHierarchy = RoleHierarchy::select('role_hierarchy.role_id', 'roles.name')
            ->join('roles', 'roles.id', '=', 'role_hierarchy.role_id')
            ->orderBy('role_hierarchy.hierarchy', 'asc')->get();
            $flag = false;
            foreach($roleHierarchy as $roleHier){
                foreach($userRoles as $userRole){
                    if($userRole == $roleHier['name']){
                        $role = $userRole;
                        $flag = true;
                        break;
                    }
                }
                if($flag === true){
                    break;
                }
            }
        }else{
            $role = 'guest';
        }
		if ($role == 'user' || $role == 'sales'){
			$extra = '<li class="c-sidebar-nav-title">                         
				Servizi
			</li>';
			$categories = ServiceCategory::all();
			foreach ($categories as $category){
				$extra .= '<li class="c-sidebar-nav-item">
							<a class="c-sidebar-nav-link c-active" href="/users/services/category/'.$category->id.'">				 
							'.$category->name.'
							</a>
						</li>';
			}
		}
        $menus = new GetSidebarMenu();
        $menulists = Menulist::all();
        $result = array();
        foreach($menulists as $menulist){
            $result[ $menulist->name ] = $menus->get( $role, App::getLocale(), $menulist->id );
        }
        view()->share('appMenuExtra', $extra );
        view()->share('appMenus', $result );
        view()->share('locales', MenuLangList::all() );
        view()->share('appLocale', App::getLocale() );
        return $next($request);
    }
}