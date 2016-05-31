<?php

namespace App\Jobs\Ticket\Deployed;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;

use Rowboat\Ticket\Events\Ticket\Broadcast\TicketClosed as BroadcastTicketClosed;

use Rowboat\Notification\Models\Mongo\Notification;

class DeployedTicketEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $ticket;
    protected $comment;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(UserModel $user, TicketModel $ticket, array $comment)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle()
    {
        event(new BroadcastTicketClosed($this->ticket, $this->user,$this->comment));

        $notification = new Notification();
        $notification->pushNotificationCloseTicket($this->ticket, $this->user);
    }
}