<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail
{/**
 * Handle the event.
 *
 * @param  AccountCreated  $event
 * @return void
 */
    public function handle(AccountCreated $event)
    {
        $data = array('name' => $event->user->name, 'email' => $event->user->email, 'body' => 'Welcome to our website. Hope you will enjoy our articles');

        Mail::send('test', $data, function($message) use ($data) {
            $message->to($data['email'])
                ->subject('Welcome to our Website');
            $message->from('noreply@artisansweb.net');
        });
    }
}
