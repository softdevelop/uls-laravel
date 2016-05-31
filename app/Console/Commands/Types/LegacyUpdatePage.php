<?php

namespace App\Console\Commands\Types;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class LegacyUpdatePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:legacy_update_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Legacy type update page.';

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
        $type = $typeModel->where('alias','legacy_update_page')->first();
        if(empty($type)){
            $type = $typeModel -> create(['name' => 'Update Page','alias' => 'legacy_update_page','position_show' => 0]);
        }
        $ticketAdmin =  $permissionModel->where('slug','legacy_update_page_ticket_admin')->first();
        if(empty($ticketAdmin)){

            $ticketAdmin = $permissionModel->create(['name' => 'Legacy Page Update Ticket Admin','slug' => 'legacy_update_page_ticket_admin','description' => 'Legacy Page Update Ticket Admin']);
            $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);
        }
        

        $ticketAssignee =  $permissionModel->where('slug','legacy_update_page_ticket_assignee')->first();
        if(empty($ticketAssignee)){

            $ticketAssignee = $permissionModel->create(['name' => 'Legacy Page Update Ticket Assignee','slug' => 'legacy_update_page_ticket_assignee','description' => 'Legacy Page Update Ticket Assignee']);
            $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);
        }

        $this->info('Success!');
    }
}
