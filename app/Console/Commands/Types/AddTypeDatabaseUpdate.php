<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTypeDatabaseUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_database_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Database Update.';

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
        $type = $typeModel->where('alias', 'database_update')->first();

        if (!$type) {
            $type = $typeModel->create(['name' => 'Database Update', 'alias' => 'database_update', 'position_show' => 1]);
        }
        $ticketAdmin =  $permissionModel->where('slug','database_update_ticket_admin')->first();
        if(empty($ticketAdmin)){

            $ticketAdmin = $permissionModel->create(['name' => 'Database Update Ticket Admin', 'slug' => 'database_update_ticket_admin', 'description' => 'Database Update Ticket Admin']);
            $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);
        }
        $ticketAssignee =  $permissionModel->where('slug','database_update_ticket_admin')->first();
        if(empty($ticketAssignee)){

            $ticketAssignee = $permissionModel->create(['name' => 'Database Update Ticket Assignee', 'slug' => 'database_update_ticket_assignee', 'description' => 'Database Update Ticket Assign']);
            $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);
        }
        $this->info('End!');
    }
}
