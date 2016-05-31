<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTicketTypeRequestRegion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_request_region_variation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Request Region Variation';

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

        $checkType = $typeModel->where('alias','region_variation_request')->first();
        
        //If type empty
        if(empty($checkType)) {
            //Create type
            $type = $typeModel -> create(['name' => 'Region Variation Request','alias' => 'region_variation_request','position_show' => 0]);
            
            //------------------------------------------------------------------------------------------------------//
            //Check permission ticket admin
            $permissionTicketAdmin = $permissionModel->where('slug', 'region_request_ticket_admin')->first();

            if(empty($permissionTicketAdmin)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAdmin = $permissionModel->create(['name' => 'Region Request Approver','slug' => 'region_request_ticket_admin','description' => 'Region Request Approver']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAdmin->id, ['ticket_admin' => 1]);

            //----------------------------------------------------------------------------------------------------//
            //Check permission ticket assign
            $permissionTicketAssignee = $permissionModel->where('slug', 'region_request_ticket_assignee')->first();

            if(empty($permissionTicketAssignee)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAssignee = $permissionModel->create(['name' => 'Region Request Author','slug' => 'region_request_ticket_assignee','description' => 'Region Request Author']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAssignee->id, ['ticket_admin' => 0]);
            
            $this->info('Success!');
        } else {
            $this->info('Type has been exits!');
        }


    }
}
