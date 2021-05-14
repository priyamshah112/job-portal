<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Request $request)
    {       
        
        view()->composer('*', function ($view) 
        {
            $verticalMenus = [];
            if(Auth::check()){
                $permissions = Auth::user()->getPermissionsViaRoles();
                $permissionIds = [];
                foreach($permissions as $permission){
                    $permissionIds[] = $permission->id;
                }
                $verticalMenus = Menu::whereNull('parent_id')
                ->whereIn('permission_id',$permissionIds)
                ->orWhereNull('permission_id')->get();
                foreach($verticalMenus as $menu){
                    $submenu = Menu::where('parent_id',$menu->id)->whereIn('permission_id',$permissionIds)->get();
                    if(count($submenu) > 0){
                        $menu->submenu = $submenu;
                    }
                }
            }
            // $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
            // $horizontalMenuData = json_decode($horizontalMenuJson);
            // Share all menuData to all the views
            $view->with('menuData',$verticalMenus);
        });  
    }
}
