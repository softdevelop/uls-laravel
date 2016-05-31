<?php
namespace Rowboat\Notification\Events\Notifications\Broadcast;

use App\Podcast;
use Rowboat\Notification\Events\Event;
use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class NotificationTicket extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;


    /**
     * Create a new event instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;

    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['notification_ticket'];
    }
}