<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;

class SendPostUpdatedMail
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::queue(new \App\Mail\PostCRUD($event->post, 'updated'));
    }
}
