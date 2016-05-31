<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PagesSyncModel;


class CronJobSyncPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:sync_seo_pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job sync seo pages';

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
        return redirect('api/seo/pages/sync');

        //  $pagesSyncModel = new PagesSyncModel();
        
        // $result = $pagesSyncModel->synPages('http://www.ulsinc.com');
    }
}
