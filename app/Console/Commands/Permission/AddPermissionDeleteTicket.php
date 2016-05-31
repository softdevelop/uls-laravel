<?php

namespace App\Console\Commands\Permission;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;

class AddPermissionDeleteTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add_delete_task_manager_ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission for user to delete ticket';

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

        $permissionModel = new PermissionModel();
        $permission = $permissionModel->where('slug', 'delete_task_manager_tickets')->first();

        if (!$permission) {
            $permissionModel->create(['name' => 'Delete Task Manager Tickets', 'slug' => 'delete_task_manager_tickets', 'description' => 'Delete Task Manager Tickets']);
        }
        $this->info('End!');
    }
}
