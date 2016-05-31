<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTypePlatformIssuesRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_platform_issues_requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Platform Issues/Requests.';

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

        $checkType = $typeModel->where('alias','platform_issues_requests')->first();
        
        //If type empty
        if(empty($checkType)) {
            //Create type
            $type = $typeModel -> create(['name' => 'Platform Issues/Requests','alias' => 'platform_issues_requests','position_show' => 2]);
            
            //------------------------------------------------------------------------------------------------------//
            //Check permission ticket admin
            $permissionTicketAdmin = $permissionModel->where('slug', 'platform_issues_requests_ticket_admin')->first();

            if(empty($permissionTicketAdmin)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAdmin = $permissionModel->create(['name' => 'Platform Issues/Requests Ticket Admin','slug' => 'platform_issues_requests_ticket_admin','description' => 'Platform Issues/Requests Ticket Admin']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAdmin->id, ['ticket_admin' => 1]);

            //----------------------------------------------------------------------------------------------------//
            //Check permission ticket assign
            $permissionTicketAssignee = $permissionModel->where('slug', 'platform_issues_requests_ticket_assignee')->first();

            if(empty($permissionTicketAssignee)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAssignee = $permissionModel->create(['name' => 'Platform Issues/Requests Ticket Assignee','slug' => 'platform_issues_requests_ticket_assignee','description' => 'Platform Issues/Requests Ticket Assignee']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAssignee->id, ['ticket_admin' => 0]);
            
            $this->info('Success!');
        } else {
            $this->info('Type has been exits!');
        }

    }
}
