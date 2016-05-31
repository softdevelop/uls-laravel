<?php

namespace App\Console\Commands\Permission;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;

class AddPermissionAdvancedEditingFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add_advanced_editing_features';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type Channel Partner Update.';

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
        $permission = $permissionModel->where('slug', 'advanced_editing_features')->first();

        if (!$permission) {
            $permissionModel->create(['name' => 'Advanced Editing Features', 'slug' => 'advanced_editing_features', 'description' => 'Advanced Editing Features']);
        }
        $this->info('End!');
    }
}
