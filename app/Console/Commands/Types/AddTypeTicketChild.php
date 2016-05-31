<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTypeTicketChild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_child_ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add type for ticket child.';

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

        $arrays = ['page_html','page_content','page_visual','page_seo'];

        foreach ($arrays as $key => $value) {
            $checkType = $typeModel->where('alias',$value)->first();
        
            //If type empty
            if(empty($checkType)) {
                $typeName = ucwords(str_replace('_', ' ', $value));
                //Create type
                $type = $typeModel -> create(['name' => $typeName,'alias' => $value,'position_show' => 0]);
                
                //------------------------------------------------------------------------------------------------------//
                //Check permission ticket admin
                $permissionTicketAdmin = $permissionModel->where('slug', $value.'_ticket_admin')->first();

                if(empty($permissionTicketAdmin)) { //if has not been exit permission ticket admin
                    //create permission
                    $permissionTicketAdmin = $permissionModel->create(['name' => $typeName.' Ticket Admin','slug' => $value.'_ticket_admin','description' => $checkType.' Ticket Admin']);
                }
                //attach permission ticket admin for type
                $type->pemissions()->attach($permissionTicketAdmin->id, ['ticket_admin' => 1]);

                //----------------------------------------------------------------------------------------------------//
                //Check permission ticket assign
                $permissionTicketAssignee = $permissionModel->where('slug', $value.'_ticket_assignee')->first();

                if(empty($permissionTicketAssignee)) { //if has not been exit permission ticket admin
                    //create permission
                    $permissionTicketAssignee = $permissionModel->create(['name' => $typeName.' Ticket Assignee','slug' => $value.'_ticket_assignee','description' => $typeName.' Ticket Assignee']);
                }
                //attach permission ticket admin for type
                $type->pemissions()->attach($permissionTicketAssignee->id, ['ticket_admin' => 0]);
                
                $this->info('Success!');
            } else {
                $this->info('Type has been exits!');
            }
        }
    }
}
