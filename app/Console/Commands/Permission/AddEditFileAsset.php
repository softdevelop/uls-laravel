<?php

namespace App\Console\Commands\Permission;

use App\Models\PermissionModel;
use Illuminate\Console\Command;

class AddEditFileAsset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_edit_file_asset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add  type edit file Asset.';

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

        $permission = $permissionModel->where('slug','eidt_file_asset')->first();
        
        //If type empty
        if(empty($permission)) {
           $permissionModel->create(['name' => 'Edit File Asset','slug' => 'eidt_file_asset','description' => 'Permission edit file asset']);
        } else {
            $this->info('Type has been exits!');
        }
        $this->info('Success!');
    }
}
