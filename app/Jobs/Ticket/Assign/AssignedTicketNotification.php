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
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;

class AssignedTicketNotification extends Job implements SelfHandling, ShouldQueue
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
        $ticket = $this->ticket->getDetail();

        $message = 'Ticket ##ticket# has been assigned by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);
        $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);

        $userId = [];
        $userModel = new UserModel();
        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($this->ticket->getPermissionsName(true));
        foreach ($usersInDepartment as $key => $value) {
            if($value->id != $this->user->id) {
                $userId[] = $value->id;
            }
        }

        $data = [
            'sender_id'=>$this->user->id,
            'user_id'=>array_merge($userId,[$ticket['assign_id'],$ticket['user_id']]),
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'assign_ticket'
        ];

        event(new NotificationTicket($data));
        $notification = new Notification();
        $notification->create($data);

        if($this->historyId != null){
            // send notification to old people of ticket
            $message = 'Ticket ##ticket# has been removed by #actionUser#';
            $message = str_replace('#ticket#', $ticket['id'], $message);
            $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);

            $data1 = [
                'sender_id'=>$this->user->id,
                'user_id'=> [$this->historyId],
                'message' => $message,
                'href'=>'support/show/'.$ticket['id'],
                'event'=>'remove_assign_ticket'
            ];

            event(new NotificationTicket($data1));
            $notification1 = new Notification();
            $notification1->create($data1);

        }

       
    }
}