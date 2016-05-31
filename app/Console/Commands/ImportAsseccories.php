<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportAsseccories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:import_accessories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import accessoires';

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
        $this->info("Importing accessories: ");

        $host = env('DB_HOST', 'localhost');

        $username = env('DB_USERNAME', 'root');

        $password = env('DB_PASSWORD', 'secret');

        $database = 'ulsincdb';

        $configOldDb = [
            'driver'    => 'mysql',
            'host'      => $host,
            'database'  => $database,
            'username'  => $username,
            'password'  => $password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ];

        \Config::set('database.connections.old_db', $configOldDb);
        
        $oldConnection = \DB::connection('old_db');
        \DB::table('accessories')->delete();
        $accessories = $oldConnection->select('select * from all_accessories');

        $data = json_decode( json_encode($accessories) ,true);

        foreach ($data as $key => &$value) {
            unset($value['accessory_id'], $value['page_id'], $value['section_id'], $value['active_dev']);
        }
        \DB::table('accessories')->insert($data);

       $this->info('done');
        
    }
}
