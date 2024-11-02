<?php

namespace App\Jobs;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyUIDReceived implements ShouldQueue
{
    use Queueable;

    public $uid;

    public User $user;

    /**
     * Create a new job instance.
     */
    public function __construct($uid, User $user)
    {
        $this->uid = $uid;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(
            Notification::make()
                ->title('UID Received')
                ->body('UID has been received')
                ->success()
                ->toBroadcast()
        );
    }
}
