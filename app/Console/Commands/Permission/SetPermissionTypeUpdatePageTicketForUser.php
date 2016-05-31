<?php

namespace App\Console\Commands\Permission;

use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;
use Rowboat\Users\Models\PermissionModel;
use Rowboat\Users\Models\UserModel;

class SetPermissionTypeUpdatePageTicketForUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:set_permission_pageupdate_foruser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set permission of old type update page for user.';

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
        
        $permissionLegacyTicketAdmin = $permissionModel->where('slug','legacy_update_page_ticket_admin')->first();
        $permissionLegacyTicketAssignee = $permissionModel->where('slug','legacy_update_page_ticket_assignee')->first();

        $permissionUpdatePageTicketAdmin = $permissionModel->where('slug','update_page_ticket_admin')->first();
        $permissionUpdatePageTicketAssignee = $permissionModel->where('slug','update_page_ticket_assignee')->first();


        $perUserLegacyTicketAdmins = \DB::table('permission_user')->where('permission_id',$permissionLegacyTicketAdmin->id)->get();
        foreach ($perUserLegacyTicketAdmins as $value) {
        	\DB::table('permission_user')
            ->where('id', $value->id)
            ->update(['permission_id' => $permissionUpdatePageTicketAdmin->id]);
        }

        $perUserLegacyTicketAssignees = \DB::table('permission_user')->where('permission_id',$permissionLegacyTicketAssignee->id)->get();
        foreach ($perUserLegacyTicketAssignees as $value1) {
        	\DB::table('permission_user')
            ->where('id', $value1->id)
            ->update(['permission_id' => $permissionUpdatePageTicketAssignee->id]);
        }

        $this->info('Success!');
    }
}
