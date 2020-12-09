<?php
/*
*   07.11.2019
*   MenusMenu.php
*/
namespace App\Http\Menus;

use App\MenuBuilder\MenuBuilder;
use Illuminate\Support\Facades\DB;
use App\Models\Menus;
use App\MenuBuilder\RenderFromDatabaseData;

class GetSidebarMenu implements MenuInterface{

    private $mb; //menu builder
    private $menu;

    public function __construct(){
        $this->mb = new MenuBuilder();
    }

    private function getMenuFromDB($menuId, $menuName, $locale){
        $this->menu = Menus::join('menu_role', 'menus.id', '=', 'menu_role.menus_id')
            ->join('menus_lang', 'menus.id', '=', 'menus_lang.menus_id')
            ->select('menus.*', 'menus_lang.name as name')
            ->where('menus.menu_id', '=', $menuId)
            ->where('menu_role.role_name', '=', $menuName)
            ->where('menus_lang.lang', '=', $locale)
            ->orderBy('menus.sequence', 'asc')->get();
    }

    private function getGuestMenu($locale, $menuId){
        $this->getMenuFromDB($menuId, 'guest', $locale);
    }

    private function getUserMenu($locale, $menuId){
        $this->getMenuFromDB($menuId, 'user', $locale);
    }

    private function getAdminMenu($locale, $menuId){
        $this->getMenuFromDB($menuId, 'admin', $locale);
    }

    public function get($role, $locale, $menuId = 2){
        $this->getMenuFromDB($menuId, $role, $locale);
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }

    public function getAll( $locale, $menuId=2 ){
        $this->menu = Menus::join('menus_lang', 'menus.id', '=', 'menus_lang.menus_id')
            ->select('menus.*', 'menus_lang.name as name')
            ->where('menus.menu_id', '=',  $menuId)
            ->where('menus_lang.lang', '=', $locale)
            ->orderBy('menus.sequence', 'asc')->get();
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }
}
