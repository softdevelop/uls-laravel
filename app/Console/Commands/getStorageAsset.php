<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class getStorageAsset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 's3:get_assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('start');

        $s3 = \Storage::disk('s3');

        $files = $s3->allFiles('assets');

        foreach ($files as $key => $value) {
            \Storage::put('huy/'.$value, $s3->get($value));
        }

        $this->info('end');
    }
}
