<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Models\User;
use App\Notifications\NewPostNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewPostNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        //stuur notificatie naar alle admins

        $admins = User::whereHas('roles',function($query){
            $query->where('name','admin');
        })->get();
        foreach($admins as $admin){
            $admin->notify(new NewPostNotification($event->post));
        }

    }
}
