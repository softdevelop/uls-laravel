<?php
namespace Rowboat\Ticket\Events\Ticket\Broadcast;

use App\Podcast;
use Rowboat\Ticket\Events\Event;
use Illuminate\Queue\SerializesModels;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class TicketPrivate extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $ticket;
    public $sender;
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct(TicketModel $ticket, UserModel $sender, array $comment)
    {
        $this->ticket = $ticket;
        $this->sender = $sender;
        $this->comment = $comment;
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['ticket_'.$this->ticket->id];
    }
}