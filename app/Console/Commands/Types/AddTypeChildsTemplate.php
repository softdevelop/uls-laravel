<?php

namespace App\Console\Commands\Types;

use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Ticket\Models\TypeModel;

use Rowboat\Ticket\Models\Mongo\TicketModelMongo;
use Rowboat\Users\Models\UserModel;
use App\Models\PermissionModel;

class AddTypeChildsTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_childs_type_template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update childs type template';

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

        $typeTemplate = $typeModel->where('alias','request_template')->first();

        $childType = [
                      'template_visual_design' => 'Template Visual Design',
                      'template_html' => 'Template HTML', 
                      'template_build' => 'Template Build'
                     ];

        if($typeTemplate) {
            foreach ($childType as $alias => $name) {
                $checkType = $typeModel->where('alias',$alias)->count();
                if(!$checkType) {
                    $type = $typeModel->create(['alias' => $alias, 
                                        'name' => $name, 
                                        'position_show' => 0, 
                                        'term_id' => null, 
                                        'parent_id' => $typeTemplate->id
                                       ]);
                    //------------------------------------------------------------------------------------------------------//
                    //Check permission ticket admin
                    $permissionTicketAdmin = $permissionModel->where('slug', $alias.'_ticket_admin')->first();

                    if(empty($permissionTicketAdmin)) { //if has not been exit permission ticket admin
                        //create permission
                        $permissionTicketAdmin = $permissionModel->create(['name' => $name.' Ticket Admin','slug' => $alias.'_ticket_admin','description' => $name.' Ticket Admin']);
                    }
                    //attach permission ticket admin for type
                    $type->pemissions()->attach($permissionTicketAdmin->id, ['ticket_admin' => 1]);

                    //----------------------------------------------------------------------------------------------------//
                    //Check permission ticket assign
                    $permissionTicketAssignee = $permissionModel->where('slug', $alias.'_ticket_assignee')->first();

                    if(empty($permissionTicketAssignee)) { //if has not been exit permission ticket admin
                        //create permission
                        $permissionTicketAssignee = $permissionModel->create(['name' => $name. ' Ticket Assignee','slug' => $alias. '_ticket_assignee','description' => $name. ' Ticket Assignee']);
                    }
                    //attach permission ticket admin for type
                    $type->pemissions()->attach($permissionTicketAssignee->id, ['ticket_admin' => 0]);
                }
            }
        }

        $this->info('Success!');
    }
}
