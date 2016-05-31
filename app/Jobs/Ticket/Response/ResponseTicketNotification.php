<?php

namespace App\Jobs\Ticket\Response;

use App\Jobs\Job;
use App\Http\Controllers\Controller;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;

use Rowboat\Ticket\Events\Ticket\TicketCreated;
use Rowboat\Ticket\Events\Ticket\Broadcast\TicketResponse as BroadcastTicketResponse;

use Rowboat\Notification\Models\Mongo\Notification;
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;

class ResponseTicketNotification extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $ticket;
    protected $comment;
    protected $response;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(UserModel $user, TicketModel $ticket, array $comment, $response)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->comment = $comment;
        $this->response = $response;
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

        // $originator = UserModel::findOrFail($ticket['user_id']);

        $message = 'Ticket ##ticket# has been updated by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);

        $message = str_replace('#actionUser#',  $this->user->first_name .' '. $this->user->last_name, $message);
        
        /*Get users to send email*/
        $userModel = new UserModel();
        $sysAdmin = $userModel->getUsersBelongToPermissionsName('system_administrator');        
        $ticketAdmin = $userModel->getUsersBelongToPermissionsName($this->ticket->getPermissionsName(true)); 

        //Ticket admin
        $ticketAdminId = [];
        foreach ($ticketAdmin as $receiver) {
            if($receiver->id != $this->user->id){
                $ticketAdminId[] = $receiver->id;
            }
        }
        //System administrator
        $sysAdminId = [];
        if($ticket['status'] == 'approved') {
            foreach ($sysAdmin as $receiver) {
                if($receiver->id != $this->user->id){
                    $sysAdminId[] = $receiver->id;
                }
            }
        }
        //Invites
        $invitesId = [];
        if(isset($ticket['invitations']) && !empty($ticket['invitations'])){
            foreach ($ticket['invitations'] as $receiver) {
                if($receiver['user_id'] != $this->user->id){
                    $invitesId[] = $receiver['user_id'];
                }
            }
        }

        $temp = [];

        if(isset($ticket['assign_id']) && $ticket['assign_id'] != $this->user->id){
            $temp[] = $ticket['assign_id'];
        }

        if($ticket['user_id'] != $this->user->id){
            $temp[] = $ticket['user_id'];
        }

        $userNotification = array_values(array_unique(array_merge($sysAdminId, $ticketAdminId, $invitesId, $temp)));

        $data = [
            'sender_id'=>$this->user->id,
            'user_id'=> $userNotification,
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'response_ticket'
            ];

        event(new NotificationTicket($data));
        $notification = new Notification();
        $notification->create($data);
    }
}