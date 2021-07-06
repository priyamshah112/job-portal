<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Notification;
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
            $notifications = [];
            $notification_count = 0;

            if(Auth::check()){
                $permissionIds = Auth::user()->getPermissionsViaRoles()->pluck('id');
                $verticalMenus = Menu::whereNull('parent_id')
                ->whereIn('permission_id',$permissionIds)
                ->orWhereNull('permission_id')->get();

                $notification_query = Notification::where([
                    'receiver_id' => Auth::user()->id,
                    'status' => 'unread'
                ])
                ->with('sender')
                ->orderBy('updated_at','DESC');

                $notifications = $notification_query->limit(3)->get();
                $notification_count = $notification_query->count();
            }

            $view->with([
                'menuData' => $verticalMenus,
                'notification_count' => $notification_count,
                'notifications' => $notifications
            ]);
        });
    }
}
