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

class ResponseTicketEmail extends Job implements SelfHandling, ShouldQueue
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
        event(new BroadcastTicketResponse($this->ticket, $this->user,$this->comment, $this->response));

        $notification = new Notification();
        $notification->pushNotificationResponseTicket($this->ticket, $this->user);
    }
}