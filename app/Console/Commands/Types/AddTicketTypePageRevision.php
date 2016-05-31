<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTicketTypePageRevision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_page_revision';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type page revision.';

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
        $this->info('Start...');

        $typeModel = new TypeModel();
        $permissionModel = new PermissionModel();
        $checkType = $typeModel->where('alias', 'page_revision')->count();
        if($checkType==0){
            $type = $typeModel -> create(['name' => 'Page Revision','alias' => 'page_revision','position_show' => 0]);
            
            $ticketAdmin = $permissionModel->where('slug','create_new_page_ticket_admin')->first();
            if($ticketAdmin) {
                $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);                
            }

            $ticketAssignee = $permissionModel->where('slug','create_new_page_ticket_assignee')->first();
            if($ticketAssignee) {
                $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);                
            }
        }

        $this->info('Success!');

    }
}
