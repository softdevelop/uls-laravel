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
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;

class DeployedTicketNotification extends Job implements SelfHandling, ShouldQueue
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
        $ticket = $this->ticket->getDetail();        
        $userModel = new UserModel();

        $message = 'Ticket ##ticket# has been closed by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);
        $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);
        
        $invitations = [];

        if( isset($ticket['invitations']) &&  !empty($ticket['invitations'])){
            foreach($ticket['invitations'] as $key => $invitationId){
                $invitations[] = $invitationId['user_id'];
            }
        }

        $ticketAdmin = [];
        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($this->ticket->getPermissionsName(true));
        foreach ($usersInDepartment as $key => $value) {
            $ticketAdmin[] = $value->id;
        }

        $data = [
            'sender_id'=>$this->user->id,
            'user_id'=>array_merge($invitations,$ticketAdmin, [$ticket['user_id'],$ticket['assign_id']]),
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'response_ticket'
        ];

        event(new NotificationTicket($data));
        $notification = new Notification();
        $notification->create($data);
    }
}