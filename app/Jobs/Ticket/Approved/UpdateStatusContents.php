<?php

namespace App\Jobs\Ticket\Approved;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use Rowboat\Ticket\Models\TicketModel;
use App\Models\Mongo\ContentModelMongo;

class UpdateStatusContents extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $ticket;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(TicketModel $ticket, $status)
    {
        $this->ticket = $ticket;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle()
    {
        $contentModelMongo = new ContentModelMongo();
        $contentModelMongo->updateStatusContents($this->ticket->id, $this->status);
    }
}