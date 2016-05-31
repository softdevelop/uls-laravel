<?php

namespace App\Console\Commands;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TicketModel;
use DateTime;

class changeTimerTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:changeTimerTicket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change timer ticket';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('* Start Change time_consuming collum');
        $tickets = \DB::table('tickets')->where('status','approved')->get();
        foreach ($tickets as $ticket) {
            $date_diff = date_diff(new DateTime($ticket->created_at),new DateTime($ticket->updated_at));
            $ticket->time_consuming = $date_diff->d.":".$date_diff->h.":".$date_diff->i.":".$date_diff->s;
            var_dump('Update ticket #'. $ticket->id.', Set time_consuming: ' .$ticket->time_consuming);
            \DB::table('tickets')->where('id',$ticket->id)->update(['time_consuming' => $ticket->time_consuming ]);
        }
        $this->info('* Finish');
    }
}
