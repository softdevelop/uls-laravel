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
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;

class ApprovedTicketNotification extends Job implements SelfHandling, ShouldQueue
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

        $userId = [];
        
        $message = 'Ticket ##ticket# has been approved by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);
        $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);
        
        //notification to system administrator
        $userModel = new UserModel();
        $list_SysAdmin =  $userModel->getUsersBelongToPermissionsName('system_administrator');
        foreach ($list_SysAdmin as $key => $value) {
            $userId[] = $value->id;
        }

        $data = [
            'sender_id'=>$this->user->id,
            'user_id'=>$userId,
            'message' => $message, 'href'=>'support/show/'.$ticket['id'],
            'href'=>'support/show/'.$ticket['id']
        ];

        event(new NotificationTicket($data));
        $notification = new Notification();
        $notification->create($data);
    }
}