<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AccountCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
