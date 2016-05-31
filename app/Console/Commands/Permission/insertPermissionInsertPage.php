<?php

namespace App\Console\Commands\Permission;

use App\Models\PermissionModel;
use Illuminate\Console\Command;

class insertPermissionInsertPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:addInsertPage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add perrmission insert pages';

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
        $this->info('Begin...');
        $permissionsModel = new PermissionModel();
        $checkPermission = $permissionsModel->where('slug','edit_page')->first();
        if(empty($checkPermission)){
            $permissionsModel->create(['name' => 'Edit Page','slug' => 'edit_page','description' => 'Permission edit page']);
        }
        $this->info('Success!');
    }
}
