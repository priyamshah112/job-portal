<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationAPIController extends AppBaseController
{

    public function index(Request $request)
    {
        $notifications = Notification::where([
            'receiver_id' => $request->user()->id,
            'status' => 'unread'
        ])
        ->orderBy('updated_at','DESC')
        ->get();

        return $this->sendResponse($notifications, 'Notifications retrieved successfully');
    }
    
    public function mark_all_unread_to_read(Request $request)
    {
        $notifications = Notification::where([
                'receiver_id' => $request->user()->id,
                'status' => 'unread'
            ])
            ->orderBy('updated_at','DESC')
            ->get();

        foreach ($notifications as $notification)
        { 
            $data = Notification::find($notification->id);
            if(!empty($data))
            {
                $data->update(['status' => 'read']);
            }
        }

        return $this->sendResponse($notifications, 'Notifications mark all as read !!');
    }  

    public function mark_read($id){
        $notification = Notification::findOrFail($id);
        $notification->update(['status' => 'read']);
        return $this->sendResponse($notification, 'Notification mark as read !!');
    }

    public function unread_notification_count(Request $request){
        $notification_count = Notification::where([
            'receiver_id' => $request->user()->id,
            'status' => 'unread'
        ])
        ->count();

        return $this->sendResponse($notification_count, 'Notification count retrieved successfully');
    }
}
