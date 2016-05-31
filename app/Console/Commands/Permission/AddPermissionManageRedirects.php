<?php

namespace App\Console\Commands\Permission;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;

class AddPermissionManageRedirects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add_manage_redirects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Permission to manage redirects.';

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
        $permission = $permissionModel->where('slug', 'manage_redirects')->first();

        if (!$permission) {
            $permissionModel->create(['name' => 'Manage Redirects', 'slug' => 'manage_redirects', 'description' => 'Manage Redirects']);
        }
        $this->info('End!');
    }
}
