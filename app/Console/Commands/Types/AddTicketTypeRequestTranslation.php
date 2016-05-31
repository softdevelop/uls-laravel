<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTicketTypeRequestTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_request_translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Request Translation';

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

        $checkType = $typeModel->where('alias','translation_request')->first();
        
        //If type empty
        if(empty($checkType)) {
            //Create type
            $type = $typeModel -> create(['name' => 'Translation Request','alias' => 'translation_request','position_show' => 0]);
            
            //------------------------------------------------------------------------------------------------------//
            //Check permission ticket admin
            $permissionTicketAdmin = $permissionModel->where('slug', 'translation_request_ticket_admin')->first();

            if(empty($permissionTicketAdmin)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAdmin = $permissionModel->create(['name' => 'Translation Request Approver','slug' => 'translation_request_ticket_admin','description' => 'Translation Request Approver']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAdmin->id, ['ticket_admin' => 1]);

            //----------------------------------------------------------------------------------------------------//
            //Check permission ticket assign
            $permissionTicketAssignee = $permissionModel->where('slug', 'translation_request_ticket_assignee')->first();

            if(empty($permissionTicketAssignee)) { //if has not been exit permission ticket admin
                //create permission
                $permissionTicketAssignee = $permissionModel->create(['name' => 'Translation Request Author','slug' => 'translation_request_ticket_assignee','description' => 'Translation Request Author']);
            }
            //attach permission ticket admin for type
            $type->pemissions()->attach($permissionTicketAssignee->id, ['ticket_admin' => 0]);
            
            $this->info('Success!');
        } else {
            $this->info('Type has been exits!');
        }


    }
}
