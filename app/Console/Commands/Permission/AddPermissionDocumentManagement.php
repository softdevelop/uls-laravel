<?php

namespace App\Console\Commands\Permission;

use Rowboat\Users\Models\PermissionModel;
use Illuminate\Console\Command;

class AddPermissionDocumentManagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add_permission_document_management';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission document management';

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
        $permissionRowBoat = $permissionModel->where('slug', 'document_management_rowboat')->first();
        $permissionClient = $permissionModel->where('slug', 'document_management_clients')->first();
        $permissionDocument = $permissionModel->where('slug', 'document_manger')->first();
        if(!empty($permissionRowBoat)){
            $permissionRowBoat->delete();
        }
        if(!empty($permissionClient)){
            $permissionClient->delete();
        }
        if (!$permissionDocument) {
            $permissionModel->create(['name' => 'Document Manger', 'slug' => 'document_manger', 'description' => 'Document Manger']);
        }
        $this->info('End!');
    }
}
