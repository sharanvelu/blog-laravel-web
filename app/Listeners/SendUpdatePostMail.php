<?php

namespace App\Listeners;

use App\Events\PostUpdated;
use Illuminate\Support\Facades\Mail;

class SendUpdatePostMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostUpdated  $event
     * @return void
     */
    public function handle(PostUpdated $event)
    {
        Mail::queue(new \App\Mail\PostUpdated($event->post));
    }
}
