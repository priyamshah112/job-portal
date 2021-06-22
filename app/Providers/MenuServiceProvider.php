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
                $permissionIds = Auth::user()->getPermissionsViaRoles()->pluck('id');
                $verticalMenus = Menu::whereNull('parent_id')
                ->whereIn('permission_id',$permissionIds)
                ->orWhereNull('permission_id')->get();
            }
            // $horizontalMenuJson = file_get_contents(base_path('resources/data/menu-data/horizontalMenu.json'));
            // $horizontalMenuData = json_decode($horizontalMenuJson);
            // Share all menuData to all the views
            $view->with('menuData',$verticalMenus);
        });
    }
}
