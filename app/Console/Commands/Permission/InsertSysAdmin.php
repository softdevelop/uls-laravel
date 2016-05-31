<?php

namespace App\Console\Commands\Permission;

use App\Models\PermissionModel;
use Illuminate\Console\Command;

class InsertSysAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:sys_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $per = new PermissionModel([
            'name' => 'System Administrator',
            'slug'=>'system_administrator',
            'description' => 'System Administrator'
        ]);
        $checkPermission =  PermissionModel::where('slug','system_administrator')->first();
        if(empty($checkPermission)){

            $per->save();
        }
        $this->info('Success!');
    }
}
