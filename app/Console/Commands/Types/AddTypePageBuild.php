<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTypePageBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_page_build';

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

        $checkType = $typeModel->where('alias','page_build')->first();
        
        //If type empty
        if(empty($checkType)) {
            //Create type
            $type = $typeModel -> create(['name' => 'Page Build','alias' => 'page_build','position_show' => 0]);
            
            //------------------------------------------------------------------------------------------------------//
            //Check permission ticket admin
            $permissionTicketAdmin = $permissionModel->where('slug', 'page_build_ticket_admin')->first();

            if(empty($permissionTicketAdmin)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAdmin = $permissionModel->create(['name' => 'Page Build Ticket Admin','slug' => 'page_build_ticket_admin','description' => 'Page Build Ticket Admin']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAdmin->id, ['ticket_admin' => 1]);

            //----------------------------------------------------------------------------------------------------//
            //Check permission ticket assign
            $permissionTicketAssignee = $permissionModel->where('slug', 'page_build_ticket_assignee')->first();

            if(empty($permissionTicketAssignee)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAssignee = $permissionModel->create(['name' => 'Page Build Ticket Assignee','slug' => 'page_build_ticket_assignee','description' => 'Page Build Ticket Assignee']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAssignee->id, ['ticket_admin' => 0]);
            
            $this->info('Success!');
        } else {
            $this->info('Type has been exits!');
        }

    }
}
