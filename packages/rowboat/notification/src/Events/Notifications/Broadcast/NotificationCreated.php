<?php
namespace Rowboat\Ticket\Events\Ticket\Broadcast;

use App\Podcast;
use Rowboat\Ticket\Events\Event;
use Illuminate\Queue\SerializesModels;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class TicketCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $ticket;
    public $creator;
    public $assignId;

    /**
     * Create a new event instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct(TicketModel $ticket, UserModel $creator, $assignId = null)
    {
        $this->ticket = $ticket;
        $this->creator = $creator;
        $this->assignId = $assignId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['ticket'];
    }
}