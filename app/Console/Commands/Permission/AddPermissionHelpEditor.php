<?php

namespace App\Console\Commands\Permission;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;

class AddPermissionHelpEditor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add_permission_help_editor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission help editor';

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
        $permission = $permissionModel->where('slug', 'help_content_writer')->first();

        if ($permission == null) {
            $permissionModel->create(['name' => 'Help Content Writer', 'slug' => 'help_content_writer', 'description' => 'Help Content Writer']);
        }
        $this->info('End!');
    }
}
