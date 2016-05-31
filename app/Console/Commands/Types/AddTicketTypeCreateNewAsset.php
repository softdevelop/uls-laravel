<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTicketTypeCreateNewAsset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_create_new_asset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Create New Asset.';

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

        $checkTypeAsset = $typeModel->where('alias','create_new_asset')->first();
        
        //If type empty
        if(empty($checkTypeAsset)) {
            //Create type
            $type = $typeModel -> create(['name' => 'Create New Asset','alias' => 'create_new_asset','position_show' => 0]);
            
            //------------------------------------------------------------------------------------------------------//
            //Check permission ticket admin
            $permissionTicketAdmin = $permissionModel->where('slug', 'create_new_asset_ticket_admin')->first();

            if(empty($permissionTicketAdmin)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAdmin = $permissionModel->create(['name' => 'Asset Approver','slug' => 'create_new_asset_ticket_admin','description' => 'Asset Approver']);
                //attach permission ticket admin for type
                $type->pemissions()->attach($permissionTicketAdmin->id, ['ticket_admin' => 1]); 
            }

            //----------------------------------------------------------------------------------------------------//
            //Check permission ticket assign
            $permissionTicketAssignee = $permissionModel->where('slug', 'create_new_asset_ticket_assignee')->first();

            if(empty($permissionTicketAssignee)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAssignee = $permissionModel->create(['name' => 'Asset Author','slug' => 'create_new_asset_ticket_assignee','description' => 'Asset Author']);
                //attach permission ticket admin for type
                $type->pemissions()->attach($permissionTicketAssignee->id, ['ticket_admin' => 0]);
            }
            
            $this->info('Success!');
        } else {
            $this->info('Type has been exits!');
        }


    }
}
