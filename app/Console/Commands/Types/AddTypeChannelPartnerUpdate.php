<?php

namespace App\Console\Commands\Types;

use App\Models\PermissionModel;
use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TypeModel;

class AddTypeChannelPartnerUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:add_channel_partner_update';

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

        $typeModel = new TypeModel();
        $permissionModel = new PermissionModel();
        $type = $typeModel->where('alias', 'channel_partner_update')->first();

        if (!$type) {
            $type = $typeModel->create(['name' => 'Channel Partner Update', 'alias' => 'channel_partner_update', 'position_show' => 1]);
        }
        $ticketAdmin =  $permissionModel->where('slug','update_page_ticket_admin')->first();
        if(empty($ticketAdmin)){

            $ticketAdmin = $permissionModel->create(['name' => 'Channel Partner Update Ticket Admin', 'slug' => 'channel_partner_update_ticket_admin', 'description' => 'Channel Partner Update Ticket Admin']);
            $type->pemissions()->attach($ticketAdmin->id, ['ticket_admin' => 1]);
        }

        $ticketAssignee =  $permissionModel->where('slug','update_page_ticket_admin')->first();
        if(empty($ticketAssignee)){

            $ticketAssignee = $permissionModel->create(['name' => 'Channel Partner Update Ticket Assignee', 'slug' => 'channel_partner_update_ticket_assignee', 'description' => 'Channel Partner Update Ticket Assign']);
            $type->pemissions()->attach($ticketAssignee->id, ['ticket_admin' => 0]);
        }
        $this->info('End!');
    }
}
