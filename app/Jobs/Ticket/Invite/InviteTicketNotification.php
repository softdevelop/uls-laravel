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
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;

class InviteTicketNotification extends Job implements SelfHandling, ShouldQueue
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
        $ticket = $this->ticket->getDetail();
        $message = 'You have been added as a follower of Ticket ##ticket# by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);
        $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);
              
        $data = [
            'sender_id'=>$this->user->id,
            'user_id'=>[$this->userId] ,
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'invite_ticket'
        ];
        event(new NotificationTicket($data));
        $notification = new Notification();
        $notification->create($data);
    }
}