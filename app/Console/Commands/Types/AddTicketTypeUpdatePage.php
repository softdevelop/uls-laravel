<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTicketTypeUpdatePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_update_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Update page.';

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
        $type = $typeModel->where('alias','update_page')->first();
        if(empty($type)){
            $type = $typeModel -> create(['name' => 'Update Page','alias' => 'update_page','position_show' => 0]);
            
        }
        $ticketAdmin =  $permissionModel->where('slug','update_page_ticket_admin')->first();
        if(empty($ticketAdmin)){

            $ticketAdmin = $permissionModel->create(['name' => 'Update Page Ticket Admin','slug' => 'update_page_ticket_admin','description' => 'Update Page Ticket Admin']);
            $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);
            
        }
       $ticketAssignee =  $permissionModel->where('slug','update_page_ticket_assignee')->first();
        if(empty($ticketAssignee)){

            $ticketAssignee = $permissionModel->create(['name' => 'Update Page Ticket Assignee','slug' => 'update_page_ticket_assignee','description' => 'Update Page Ticket Assignee']);
            $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);
        }

        $this->info('Success!');

    }
}
