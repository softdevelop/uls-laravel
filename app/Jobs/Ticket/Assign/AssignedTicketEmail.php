<?php

namespace App\Jobs\Ticket\Assign;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;

use Rowboat\Ticket\Events\Ticket\Broadcast\TicketAssigned as BroadcastTicketAssigned;

use Rowboat\Notification\Models\Mongo\Notification;

class AssignedTicketEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $ticket;
    public $historyId;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(UserModel $user, TicketModel $ticket, $historyId = null)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->historyId = $historyId;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle()
    {
        event(new BroadcastTicketAssigned($this->ticket, $this->user));

        $notification = new Notification();
        
        if($this->historyId != null){

            $notification->pushNotificationAssignTicket($this->ticket, $this->user, $this->historyId);

        }else{

            $notification->pushNotificationAssignTicket($this->ticket, $this->user);

        }
    }
}