<?php

namespace App\Jobs\Ticket\Invite;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;

use Rowboat\Ticket\Events\Ticket\Broadcast\TicketInvite as BroadcastTicketInvite;

use Rowboat\Notification\Models\Mongo\Notification;

class InviteTicketEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $ticket;
    public $userId;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(UserModel $user, TicketModel $ticket, $userId)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle()
    {
        event(new BroadcastTicketInvite($this->ticket, $this->user, $this->userId));

        $notification = new Notification();
        $notification->pushNotificationInvite($this->ticket, $this->user, $this->userId);
    }
}