<?php

namespace App\Console\Commands\Permission;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;

class AddPermissionActivityLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add_permission_activity_log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission activity log';

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
        $permission = $permissionModel->where('slug', 'activity_log')->first();

        if ($permission == null) {
            $permissionModel->create(['name' => 'Activity Log', 'slug' => 'activity_log', 'description' => 'Activity Log']);
        }
        $this->info('End!');
    }
}
