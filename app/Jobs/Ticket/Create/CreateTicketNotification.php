<?php

namespace App\Jobs\Ticket\Create;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;

use Rowboat\Ticket\Events\Ticket\TicketCreated;
use Rowboat\Ticket\Events\Ticket\Broadcast\TicketCreated as BroadcastTicketCreated;

use Rowboat\Notification\Models\Mongo\Notification;
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;

class CreateTicketNotification extends Job implements SelfHandling, ShouldQueue
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
        $ticket = $this->ticket->getDetail();

        $userModel = new UserModel();

        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($this->ticket->getPermissionsName(true));

        $message = 'Ticket ##ticket# has been created by #actionUser#';
       
        $message = str_replace('#ticket#', $ticket['id'], $message);
        
        $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);

        $userId = [];

        foreach($usersInDepartment as $user){
            $userId[] = $user->id;
        }

        $data = [
            'sender_id'=>$this->user->id,
            'user_id'=> $userId,
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'create_ticket'
        ];

        event(new NotificationTicket($data));
        $notification = new Notification();
        $notification->create($data);
    }
}