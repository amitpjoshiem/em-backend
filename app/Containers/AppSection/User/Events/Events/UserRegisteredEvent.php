<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Events\Events;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Events\Event;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UserRegisteredEvent extends Event implements ShouldQueue
{
    /**
     * UserRegisteredEvent constructor.
     */
    public function __construct(public User $user)
    {
    }

    /**
     * Handle the Event. (Single Listener Implementation).
     */
    public function handle(): void
    {
        Log::info(sprintf('New User registration. ID = %s | Email = %s.', $this->user->id, $this->user->email));
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
