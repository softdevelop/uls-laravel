<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTicketTypeCreateNewPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_create_new_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Create New Page.';

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
        $type = $typeModel->where('alias','create_new_page')->first();
        if(empty($type)){
            $type = $typeModel -> create(['name' => 'Create New Page','alias' => 'create_new_page','position_show' => 0]);
        }
        $ticketAdmin = $permissionModel->where('slug','create_new_page_ticket_admin')->first();
        if(empty($ticketAdmin)){

            $ticketAdmin = $permissionModel->create(['name' => 'Content Approver','slug' => 'create_new_page_ticket_admin','description' => 'Content Approver']);
            $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);
        }
        

        $ticketAssignee = $permissionModel->where('slug','create_new_page_ticket_assignee')->first();
        if(empty($ticketAssignee)){

            $ticketAssignee = $permissionModel->create(['name' => 'Content Author','slug' => 'create_new_page_ticket_assignee','description' => 'Content Author']);
            $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);
        }

        $this->info('Success!');

    }
}
