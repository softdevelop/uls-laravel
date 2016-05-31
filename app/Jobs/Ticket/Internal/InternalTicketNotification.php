<?php

namespace App\Jobs\Ticket\Internal;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;

use Rowboat\Ticket\Events\Ticket\Broadcast\TicketPrivate as BroadcastTicketPrivate;

use Rowboat\Notification\Models\Mongo\Notification;
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;

class InternalTicketNotification extends Job implements SelfHandling, ShouldQueue
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

        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($this->ticket->getPermissionsName(true));

        $message = 'Ticket ##ticket# has a new internal note added by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);
        $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);
        
        /*Get users to send notification*/
        $invitations = [];
        $assigns = [];

        //users invite
        if( isset($ticket['invitations']) &&  !empty($ticket['invitations'])){
                foreach($ticket['invitations'] as $key => $invitationId){
                $invitations[] = $invitationId['user_id'];
            }
        }

        //users has been re-assign
        if( isset($ticket['history']) && !empty($ticket['history'])){
                foreach($ticket['history'] as $key => $assignId){
                $assigns[] = $assignId['user_id'];
            }
        }

        //System administrator
        $sysAdminId = [];
        if($ticket['status']=='approved') {            
            $list_SysAdmin =  $userModel->getUsersBelongToPermissionsName('system_administrator');
            foreach($list_SysAdmin as $user){
                $sysAdminId[] = $user->id;                
            }
        }

        //Ticket admin
        $userId = [];
        foreach($usersInDepartment as $user){
            $userId[] = $user->id;
        }

        $data = [
            'sender_id'=>$this->user->id,
            'user_id'=>array_merge($invitations, $assigns, $userId,$sysAdminId),
            'message' => $message,
            'href'=>'support/show/'.$ticket['id']
        ];

        event(new NotificationTicket($data));
        $notification = new Notification();
        $notification->create($data);
    }
}