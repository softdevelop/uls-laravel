<?php

namespace App\Console\Commands\Types;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class LegacyCreateNewPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:legacy_create_new_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Legacy type create new page.';

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
        $type = $typeModel->where('alias','legacy_create_new_page')->first();
        if(empty($type)){
            $type = $typeModel -> create(['name' => 'Legacy Create New Page','alias' => 'legacy_create_new_page','position_show' => 0]);
        }
        $ticketAdmin = $permissionModel->where('slug','legacy_create_new_page_ticket_admin')->first();
        if(empty($ticketAdmin)){

            $ticketAdmin = $permissionModel->create(['name' => 'Legacy Create New Page Ticket Admin','slug' => 'legacy_create_new_page_ticket_admin','description' => 'Legacy Create New Page Ticket Admin']);

            $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);
        }
        

        $ticketAssignee = $permissionModel->where('slug','legacy_create_new_page_ticket_assignee')->first();
        if(empty($ticketAssignee)){

            $ticketAssignee = $permissionModel->create(['name' => 'Legacy Create New Page Ticket Assignee','slug' => 'legacy_create_new_page_ticket_assignee','description' => 'Legacy Create New Page Ticket Assignee']);
            $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);
        }

        $this->info('Success!');
    }
}
