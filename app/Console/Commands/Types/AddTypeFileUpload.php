<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTypeFileUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_file_upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Ticket type File Upload.';

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
        $type = $typeModel->where('alias', 'file_upload')->first();

        if (!$type) {
            $type = $typeModel->create(['name' => 'File Upload', 'alias' => 'file_upload', 'position_show' => 1]);

        }
        $ticketAdmin =  $permissionModel->where('slug','file_upload_ticket_admin')->first();
        if(empty($ticketAdmin)){

            $ticketAdmin = $permissionModel->create(['name' => 'File Upload Ticket Admin', 'slug' => 'file_upload_ticket_admin', 'description' => 'File Upload Ticket Admin']);
            $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);
        }
        $ticketAssignee =  $permissionModel->where('slug','file_upload_ticket_admin')->first();
        if(empty($ticketAssignee)){

            $ticketAssignee = $permissionModel->create(['name' => 'File Upload Ticket Assignee', 'slug' => 'file_upload_ticket_assignee', 'description' => 'File Upload Ticket Assign']);
            $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);
        }
        $this->info('End!');
    }
}
