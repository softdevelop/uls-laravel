<?php

namespace App\Console\Commands\Dashboard;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;

use Rowboat\Users\Models\UserModel;
use App\Models\Mongo\DashboardModelMongo;

class CreateNewDashboardUser extends Command implements SelfHandling
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:create_new_dashboard_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Dashboard User.';

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

        $users = UserModel::withTrashed()->get();
        
        $dashboard = DashboardModelMongo::all()->toArray();

        $user_dashboard = array_fetch($dashboard, 'user_id');

        foreach ($users as $key => $user) {

            if (in_array($user->id, $user_dashboard)) continue;
            DashboardModelMongo::saveNewDashboard($user);
        }

        $this->info('Success!');
    }
}
