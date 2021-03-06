<?php

namespace App\Jobs\Ticket\Approved;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;

use Rowboat\Ticket\Events\Ticket\Broadcast\TicketApproved as BroadcastTicketApproved;

use Rowboat\Notification\Models\Mongo\Notification;

class ApprovedTicketEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $ticket;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(UserModel $user, TicketModel $ticket)
    {
        $this->user = $user;
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle()
    {
        event(new BroadcastTicketApproved($this->ticket, $this->user));

        $notification = new Notification();
        $notification->pushNotificationApproved($this->ticket, $this->user);
    }
}