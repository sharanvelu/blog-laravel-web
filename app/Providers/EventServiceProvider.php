<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AccountCreated' => [
            'App\Listeners\SendWelcomeMail',
        ],
        'App\Events\PostCreated' => [
            'App\Listeners\SendNewPostMail',
            'App\Listeners\SendPostCreatedMail'
        ],
        'App\Events\PostUpdated' => [
            'App\Listeners\SendUpdatePostMail',
            'App\Listeners\SendPostUpdatedMail'
        ],
        'App\Events\PostDeleted' => [
            'App\Listeners\SendDeletePostMail',
            'App\Listeners\SendPostDeletedMail'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
