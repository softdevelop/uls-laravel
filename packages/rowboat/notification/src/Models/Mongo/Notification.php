<?php namespace Rowboat\Notification\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Vinkla\Pusher\Facades\Pusherer;
use Rowboat\Ticket\Services\MailService;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\RoleModel;
use Rowboat\Users\Models\UserModel;
use App\Models\UserModel as User;
use App\Models\PermissionModel as Per;
use Rowboat\Ticket\Events\Ticket\Broadcast\TicketInvite as BroadcastTicketInvite;
use Rowboat\Notification\Events\Notifications\Broadcast\NotificationTicket;
use Rowboat\Ticket\Services\TimeService;

use Rowboat\Ticket\Events\Ticket\Broadcast\TicketReadyForReviewed as BroadcastTicketReadyForReviewed;
use Rowboat\Ticket\Events\Ticket\Broadcast\TicketDeny as BroadcastTicketDeny;
use Rowboat\Ticket\Events\Ticket\Broadcast\TicketApproved as BroadcastTicketApproved;
use Rowboat\Ticket\Events\Ticket\Broadcast\TicketClosed as BroadcastTicketClosed;
use Rowboat\Ticket\Events\Ticket\Broadcast\TicketAssigned as BroadcastTicketAssigned;

class Notification extends Eloquent {
    protected $collection = 'notifications';
    protected $connection = 'mongodb';
    protected $fillable = array('sender_id','user_id', 'message', 'type', 'href', 'event','read');
    protected $defaults = array(
       'is_read' => 0,
    );


    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    /**
     * Send Email
     * @param  [type] $receiver [description]
     * @param  [type] $template [description]
     * @return [type]           [description]
     */
    public function saveEmailToJobEmail($ticketObject,$ticket,$sender,$receiver,$message,$template,$lastComment,$assigned) {
        $email = MailService::checkEmail($receiver->email);
        $title = $message;

        if($sender == null) {
            $senderName = 'System';
        } else {
            $senderName = $sender->first_name .' '. $sender->last_name;            
        }

        $data = array(
            'type' => getTypes()[$ticket['type_id']],
            'actionUser' =>  $senderName,
            'name'=> $receiver->first_name .' '. $receiver->last_name,
            'ticketId'=>$ticket['id'],
            'hash' => $ticketObject->getHashOfUser($receiver->id),
            'assigned'=> $assigned,
            'lastComment' => $lastComment
        );
        // $this->create($data);
        $result = view($template, $data);

        $result->render(function($viewObject) use($data, $email, $template, $sender){

            $title = $viewObject->getFactory()->yieldContent('title');
            $senderEmail = $sender == null ? 'System' : $sender->email;
            MailService::saveInfoEmailToJobMail(['sender_email' => $senderEmail,'html' => $viewObject->render(), 'title' => $title, 'email' => $email]);
        });
    }

    /**
     * push notifications to people that invited
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationInvite($ticketObject, $senderUser,$userId){
        $ticket = $ticketObject->getDetail();
        $message = 'You have been added as a follower of Ticket #'.$ticket['id'].' by '.$senderUser->first_name .' '. $senderUser->last_name;
        
        $user = UserModel::findOrFail($userId);

        $email = MailService::checkEmail($user->email);
        $template = 'ticket::ticket.emails.invite';
        $assigned = $senderUser->first_name .' '. $senderUser->last_name;
        self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$user,$message,$template,null,$assigned);

        $data = [
            'sender_id'=>$senderUser->id,
            'user_id'=>[$userId] ,
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'invite_ticket',
            'read' => []
        ];

        event(new NotificationTicket($data));
        $this->create($data);
        event(new BroadcastTicketInvite($ticketObject, $senderUser,$userId));
    }
    /**
     * push notification create ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationCreateTicket($ticketObject, $senderUser)
    {

        $ticket = $ticketObject->getDetail();

        $userModel = new UserModel();

        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));

        $message = 'Ticket #'.$ticket['id'].' has been created by '.$senderUser->first_name .' '. $senderUser->last_name;

        $template = 'ticket::ticket.emails.create';
        $userId = [];
        foreach($usersInDepartment as $user){
            $userId[] = $user->id;
            if($user->id != $ticket['user_id']){
                //save mail to db to cron job
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$user,$message,$template,null,null);
            }
        }

        //save notification
        $data = [
            'sender_id'=>$senderUser->id,
            'user_id'=> $userId,
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'create_ticket',
            'read' => []
        ];

        event(new NotificationTicket($data));
        $this->create($data);

        // send email to owner of ticket
        $template = 'ticket::ticket.emails.owner_create';
        self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$senderUser,$message,$template,null,null);

    }
    /**
     * push notification when assign ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationAssignTicket($ticketObject, $senderUser, $history_id = null)
    {
        // send notification to new people assiend ticket
        $userId = [];

        $ticket = $ticketObject->getDetail();
        $message = 'Ticket #'.$ticket['id'].' has been assigned by '.$senderUser->first_name .' '. $senderUser->last_name;

        $userModel = new UserModel();
        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));
        
        $originator = UserModel::findOrFail($ticket['user_id']);
        $assignPeople = UserModel::findOrFail($ticket['assign_id']);

        //Send email to originator
        $template = 'ticket::ticket.emails.assign_originator';
        $assigned = $assignPeople->first_name .' '. $assignPeople->last_name;
        self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$originator,$message,$template,null,null);

        // send email to people is assigned
        if($ticket['user_id'] != $ticket['assign_id']){

            $template = 'ticket::ticket.emails.assign';
            self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$assignPeople,$message,$template,null,$assigned); 
        }
        if($history_id){
            $historyUser = UserModel::findOrFail($history_id);
            $template = 'ticket::ticket.emails.invite';
            $assigned = $senderUser->first_name .' '. $senderUser->last_name;
            self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$historyUser,$message,$template,null,$assigned);
        }

        $template = 'ticket::ticket.emails.assign_originator';
        foreach ($usersInDepartment as $user) {
            if($user->id != $ticket['user_id'] && $user->id != $ticket['assign_id']){
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$user,$message,$template,null,$assigned);
            }

            if($user->id != $senderUser->id) {
                $userId[] = $user->id;
            }
         }     

        $data = [
            'sender_id'=>$senderUser->id,
            'user_id'=>array_values(array_unique(array_merge($userId,[$ticket['assign_id'],$ticket['user_id']]))),
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'assign_ticket',
            'read' => []
        ];

        event(new NotificationTicket($data));
        $this->create($data);

        if($history_id != null){
            // send notification to old people of ticket
            $message = 'Ticket #'.$ticket['id'].' has been removed by '.$senderUser->first_name .' '. $senderUser->last_name;

            $dataHistory = [
                'sender_id'=>$senderUser->id,
                'user_id'=> [$history_id],
                'message' => $message,
                'href'=>'support/show/'.$ticket['id'],
                'event'=>'remove_assign_ticket',
                'read' => []
            ];

            event(new NotificationTicket($dataHistory));
            $this->create($dataHistory);
        }

        event(new BroadcastTicketAssigned($ticketObject, $senderUser));  
    }
    

    /**pushNotificationResponseTicket
     * push notification when response ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
    */
    public function pushNotificationResponseTicket($ticketObject, $senderUser)
    {
        $ticket = $ticketObject->getDetail();

        $lastComment = [];

        if(isset($ticket['comments']) && !empty($ticket['comments'])){

             $lastComment = end($ticket['comments']);
        }

        $originator = UserModel::findOrFail($ticket['user_id']);

        $message = 'Ticket #'.$ticket['id'].' has been updated by '.$senderUser->first_name .' '. $senderUser->last_name;
        
        /*Get users to send email*/
        $userModel = new UserModel();
        $sysAdmin = $userModel->getUsersBelongToPermissionsName('system_administrator');        
        $ticketAdmin = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));        
        $ticketAssign = [];
        if(isset($ticket['assign_id']) && !empty($ticket['assign_id'])){
            $ticketAssign = $userModel->findOrFail($ticket['assign_id']);
        }
        
        $ticketCreator = $userModel->findOrFail($ticket['user_id']);

        $invites = [];
        if(isset($ticket['invitations']) && !empty($ticket['invitations'])){
            $invites  = $userModel->whereIn('id',array_fetch($ticket['invitations'],'user_id'))->get();
        }

        /*send email to users of ticket*/

        //Send email to user system administrator
        $template = 'ticket::ticket.emails.response_ticket_admin';
        $sysAdminId = [];
        foreach ($sysAdmin as $receiver) {
            if(!empty($sysAdmin) && $ticket['status'] == 'approved') {
                $sysAdminId[] = $receiver->id;
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$receiver,$message,$template,$lastComment,null);
            }
        }

        //Send email to user ticket admin
        $template = 'ticket::ticket.emails.response_ticket_admin';
        $ticketAdminId = [];
        foreach ($ticketAdmin as $receiver) {
            if(!empty($ticketAdmin) && !in_array($receiver->id, $sysAdminId)) {
                $ticketAdminId[] = $receiver->id;
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$receiver,$message,$template,$lastComment,null);
            }
        }

        //Send email to user creator ticket
        $template = 'ticket::ticket.emails.response_originator';
        if(!in_array($ticketCreator->id, $ticketAdminId) && !empty($ticketAssign) && !in_array($ticketCreator->id, $sysAdminId)) {
            self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$ticketCreator,$message,$template,$lastComment,null);
        }

        //Send email to user ticket assign
        $template = 'ticket::ticket.emails.response_assignee';
        if(!empty($ticketAssign) && $ticketAssign->id != $ticketCreator->id && !in_array($ticketAssign->id, $ticketAdminId) && !in_array($ticketAssign->id, $sysAdminId)) {
            self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$ticketAssign,$message,$template,$lastComment,null);
        }

        //Send email to user following ticket
        $template = 'ticket::ticket.emails.response_invite';
        $invitesId = [];
        foreach ($invites as $receiver) {
            if($receiver->id != $senderUser->id){
                $invitesId[] = $receiver->id;
            }
            if(!empty($invites) && !in_array($receiver->id, $ticketAdminId) && $receiver->id != $ticketCreator->id && !in_array($receiver->id, $sysAdminId)) {
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$receiver,$message,$template,$lastComment,null);
            }
        }

        $temp = [];

        if(isset($ticket['assign_id']) && $ticket['assign_id'] != $senderUser->id){
            $temp[] = $ticket['assign_id'];
        }

        if($ticket['user_id'] != $senderUser->id){
            $temp[] = $ticket['user_id'];
        }

        $userNotification = array_values(array_unique(array_merge($sysAdminId, $ticketAdminId, $invitesId, $temp)));

        $data = [
            'sender_id'=>$senderUser->id,
            'user_id'=> $userNotification,
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'response_ticket',
            'read' => []
            ];

        event(new NotificationTicket($data));
        $this->create($data);

    }
    /**
     * push notification when close ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationCloseTicket($ticketObject, $senderUser, $comment){
        $ticket = $ticketObject->getDetail();
        $userModel = new UserModel();

        $originator = $userModel->findOrFail($ticket['user_id']);
        $message = 'Ticket #'.$ticket['id'].' has been closed by '. $senderUser->first_name .' '. $senderUser->last_name;
        
        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));
        $usersInDepartmentId = [];
        foreach($usersInDepartment as $value){
            $usersInDepartmentId[] = $value->id;
        }

        // send email to owner of ticket
        $template = 'ticket::ticket.emails.close_originator';
        self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$originator,$message,$template,null,null);

        //Send email to assignee
        if(!empty($ticket['assign_id'])){
            if($ticket['assign_id'] != $ticket['user_id']){
                $assignee = $userModel->findOrFail($ticket['assign_id']);

                $template = 'ticket::ticket.emails.close_assignee';
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$assignee,$message,$template,null,null);
            }
        }

        // Send email to invited
        $invitationsId = [];
        $template = 'ticket::ticket.emails.close_invite';
        if(isset($ticket['invitations']) && !empty($ticket['invitations'])){
            foreach($ticket['invitations'] as $invitation){
                $invitationsId[] = $invitation['user_id'];
            }
            $invitations = $userModel->whereIn('id', $invitationsId)->get();
            foreach($invitations as $user){
                if($user->id != $ticket['user_id'] && $user->id != $ticket['assign_id']){
                    self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$user,$message,$template,null,null);
                }
            }
         }

        //Send email to system administrator
        $list_SysAdmin =  $userModel->getUsersBelongToPermissionsName('system_administrator');        
        $sysAdminId = [];
        $template = 'ticket::ticket.emails.close_ticket_admin';
        foreach ($list_SysAdmin as $key => $value) {
            $sysAdminId[] = $value->id;
            if(!in_array($value->id, $invitationsId) && $value->id != $ticket['assign_id'] && $value->id != $ticket['user_id']) {
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$value,$message,$template,null,null);
            }
        }

        //Send email to ticket admin
        $template = 'ticket::ticket.emails.close_ticket_admin';
        $userPemission = UserModel::whereIn('id', $usersInDepartmentId)->whereNotIn('id',$invitationsId)->get();
        if(!empty($userPemission)){
           foreach($userPemission as $user){
                if($user->id != $ticket['user_id'] && $user->id != $ticket['assign_id'] && !in_array($user->id, $sysAdminId)){
                    self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$user,$message,$template,null,null);
                }
            }
        }

        //push notification
        $data = [
            'sender_id'=>$senderUser->id,
            'user_id'=>array_values(array_unique(array_merge($invitationsId,$usersInDepartmentId, $sysAdminId, [$ticket['user_id'],$ticket['assign_id']]))),
            'message' => $message,
            'href'=>'support/show/'.$ticket['id'],
            'event'=>'response_ticket',
            'read' => []
        ];

        event(new NotificationTicket($data));
        event(new BroadcastTicketClosed($ticketObject, $senderUser,$comment));

        $this->create($data);
    }
    /**
     * push notification when re open ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationReOpenTicket($ticketObject, $senderUser){
        $ticket = $ticketObject->getDetail();

        $userModel = new UserModel();
        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));

        $message = 'Ticket ##ticket# has been re-opened by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);
        $message = str_replace('#actionUser#',  $senderUser->first_name .' '. $senderUser->last_name, $message);
        $invitations = [];
        $assigns = [];
        if( isset($ticket['invitations']) &&  !empty($ticket['invitations'])){
                foreach($ticket['invitations'] as $key => $invitationId){
                $invitations[] = $invitationId['user_id'];
            }
        }
        if( isset($ticket['history']) && !empty($ticket['history'])){
                foreach($ticket['history'] as $key => $assignId){
                $assigns[] = $assignId['user_id'];
            }
        }

        $data = [
        'sender_id'=>$senderUser->id,
        'user_id'=>array_values(array_unique(array_merge($invitations, $assigns, [$ticket['user_id']], array_keys($usersInDepartment)))),
        'message' => $message, 'href'=>'support/show/'.$ticket['id'],
        'href'=>'support/show/'.$ticket['id'],
        'read' => []
        ];

        event(new NotificationTicket($data));

        $this->create($data);
        if(!empty($ticket['notes'])){
            $content = $ticket['notes'];
        }
        else{
            $content = '';
        }
        // send mail to users in current department
        foreach($usersInDepartment as $user){
            $email = MailService::checkEmail($user->email);// empty(\Config::get('app.email_test'))? \Config::get('app.email_test'): $user->email; // $user->email;
            $title = $message;
            $data = array(
                'type' => getTypes()[$ticket['type_id']],
                'actionUser' =>  $senderUser->first_name .' '. $senderUser->last_name,
                'name'=> $user->first_name .' '. $user->last_name,
                'ticketId'=>$ticket['id'],
                'content'=>$content,
                'hash' => $ticketObject->getHashOfUser($user->id)
            );
            $result = view('ticket::ticket.emails.re-open', $data);
            $result->render(function($viewObject) use($data, $email){
                $title = $viewObject->getFactory()->yieldContent('title');
                MailService::queue(
                        'ticket::ticket.emails.re-open',
                        $data,
                        function($message) use ($email,$title) {
                            $message->to($email)->subject($title);
                });
            });
        }

    }

    /**
     * push notification when re click Ready for revewed ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationReadyForReviewedTicket($ticketObject, $senderUser){
        $ticket = $ticketObject->getDetail();
        
        $userId = [];

        $userModel = new UserModel();
        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));
        
        if($senderUser == null) {            
            $actionUser = 'System';
            $senderId = -1;
        } else {
            $actionUser = $senderUser->first_name .' '. $senderUser->last_name;
            $senderId = $senderUser->id;
        }

        $message = 'Ticket #'.$ticket['id'].' has been ready for reviewed by '.$actionUser;
        
        //Send email to ticket admin
        $assigned = '';
        if($ticket['assign_id'] != null) {
            $assignPeople = UserModel::findOrFail($ticket['assign_id']);
            $assigned = $assignPeople->first_name .' '. $assignPeople->last_name;
        }
        $template = 'ticket::ticket.emails.readyforreview';

        foreach ($usersInDepartment as $key => $value) {
            $userId[] = $value->id;
            self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$value,$message,$template,null,$assigned);
        }

        //save notification to table in mongo
        $data = [
            'sender_id'=> $senderId,
            'user_id'=>$userId,
            'message' => $message, 'href'=>'support/show/'.$ticket['id'],
            'href'=>'support/show/'.$ticket['id'],
            'read' => []
        ];

        event(new NotificationTicket($data));
        event(new BroadcastTicketReadyForReviewed($ticketObject, $senderUser));

        $this->create($data);
    }

    /**
     * push notification when re click Ready for revewed ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationApproved($ticketObject, $senderUser){
        $ticket = $ticketObject->getDetail();
        $userId = [];

        $message = 'Ticket #'.$ticket['id'].' has been approved by '.$senderUser->first_name .' '. $senderUser->last_name;
        
        //send email for system administrator
        $userModel = new User();
        $assignPeople = $userModel -> findOrFail($ticket['assign_id']);
        $list_SysAdmin =  $userModel->getUsersBelongToPermissionsName('system_administrator');
        
        //Send email to system administrator
        $assigned = $assignPeople->first_name .' '. $assignPeople->last_name;
        $template = 'ticket::ticket.emails.approved';
        foreach ($list_SysAdmin as $key => $value) {
            $userId[] = $value->id;
            self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$value,$message,$template,null,$assigned);
        }

        //push notification
        $data = [
            'sender_id'=>$senderUser->id,
            'user_id'=>$userId,
            'message' => $message, 'href'=>'support/show/'.$ticket['id'],
            'href'=>'support/show/'.$ticket['id'],
            'read' => []
        ];

        event(new NotificationTicket($data));
        event(new BroadcastTicketApproved($ticketObject, $senderUser));

        $this->create($data);

    }

    /**
     * push notification when re click Ready for revewed ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationDeny($ticketObject, $senderUser)
    {
        $userModel = new UserModel();

        $ticket = $ticketObject->getDetail();
        $userId = [];

        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));

        $message = 'Ticket #' .$ticket['id']. ' has been deny by '.$senderUser->first_name .' '. $senderUser->last_name;
        
        //Send mail to ticket admin
        $assigned = '';
        if($ticket['assign_id'] != null) {
            $assignPeople = $userModel -> findOrFail($ticket['assign_id']);
            $assigned = $assignPeople->first_name .' '. $assignPeople->last_name;            
        }

        $template = 'ticket::ticket.emails.deny';

        //save email
        foreach ($usersInDepartment as $key => $value) {
            $userId[] = $value->id;
            self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$value,$message,$template,null,$assigned);
        }

        //push notification
        $data = [
            'sender_id'=>$senderUser->id,
            'user_id'=>$userId,
            'message' => $message, 'href'=>'support/show/'.$ticket['id'],
            'href'=>'support/show/'.$ticket['id'],
            'read' => []
        ];

        event(new NotificationTicket($data));
        event(new BroadcastTicketDeny($ticketObject, $senderUser));

        $this->create($data);
    }

    /**
     * push notification when add private comment for ticket
     * @param  [TicketModel] $ticket     [description]
     * @param  [User] $senderUser [description]
     * @return [status]             [description]
     */
    public function pushNotificationAddPrivateComment($ticketObject, $senderUser)
    {
        $ticket = $ticketObject->getDetail();

        $userModel = new UserModel();

        $usersInDepartment = $userModel->getUsersBelongToPermissionsName($ticketObject->getPermissionsName(true));

        $message = 'Ticket ##ticket# has a new internal note added by #actionUser#';
        $message = str_replace('#ticket#', $ticket['id'], $message);
        $message = str_replace('#actionUser#',  $senderUser->first_name .' '. $senderUser->last_name, $message);
        
        $owner = $userModel->findOrFail($ticket['user_id']);
        if(!empty($ticket['notes'])){
            $lastComment = $ticket['notes'];
        }
        else{
            $lastComment = '';
        }

        // Send mail to system administrator when ticket status is approved
        $template = 'ticket::ticket.emails.private';
        $listSysAdminId = [];
        if($ticket['status']=='approved') {            
            $list_SysAdmin =  $userModel->getUsersBelongToPermissionsName('system_administrator');
            foreach($list_SysAdmin as $user){
                if(!empty($list_SysAdmin)) {
                    $listSysAdminId[] = $user->id;
                    self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$user,$message,$template,$lastComment,null);
                }
            }
        }

        // send email to ticket admin
        foreach($usersInDepartment as $user){
            if(!empty($usersInDepartment) && !in_array($user->id, $listSysAdminId)) {
                self::saveEmailToJobEmail($ticketObject,$ticket,$senderUser,$user,$message,$template,$lastComment,null);
            }
        }
    }

    public function getNotificationsOfUser($user){
        $userIds = [$user->id];
        if($user->is('super_admin')) $userIds[] = 0;
        $items = $this->whereIn('user_id', $userIds)->orderBy('created_at', 'desc')->get();
        \DB::connection('mongodb')->collection('notifications')->whereIn('user_id', $userIds)
                       ->update(['is_read'=>1], ['upsert' => true]);
        
        // foreach ($items as $key => &$value) {
        //     if($value->read == null) {
        //         $value->read = [];
        //     } else {
        //         $read = $value->read;
        //     }

        //     $read[] = $user->id;

        //     $value->read = array_unique($read);
        //     $value->save();

        //     $value->created_at = date('Y-m-d H:i:s',TimeService::setTimeZoneCurrentUser( \Auth::user()->time_zone, $value->created_at));
        // }
        return $items;
    }

    public function getAmountNotificationsNotRead($user)
    {
        $userIds = [$user->id];
        if($user->is('super_admin')) $userIds[] = 0;
        $query = $this->whereIn('user_id', $userIds)->whereNotIn('read',$userIds);
        return $query->count();
    }

    public function setRead($user)
    {
        $userIds = [$user->id];
        $items = $this->whereIn('user_id', $userIds)->orderBy('created_at', 'desc')->get();
        
        foreach ($items as $value) {
            if($value->read == null) {
                $value->read = [$user->id];
                $value->save();
            } else{
                if(!in_array($user->id, $value->read)) {
                    $read = $value->read;
                    $read[]=$user->id;
                    $value->read = $read;
                    $value->save();
                }                
            }
        }
    }
}
