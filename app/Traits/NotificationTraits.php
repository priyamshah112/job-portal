<?php

namespace App\Traits;

use App\Events\SendNotification;
use App\Models\Notification;

trait NotificationTraits
{

    public function notification($data){
        
        $notification = Notification::create([
            'title'=>$data['title'],
            'description'=>$data['description'],
            'status'=>'unread',
            'receiver_id'=> $data['receiver_id'],
            'sender_id'=>$data['sender_id'],
            'updated_by'=>$data['sender_id']
        ]);
        

        broadcast(new SendNotification($data, $data['receiver_id']));

        return $notification;
    }

}