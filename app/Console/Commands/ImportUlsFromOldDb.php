<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;

class ImportUlsFromOldDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importold:uls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Branches from old db';

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

        $this->info("Importing uls: ");

        $host = env('DB_HOST', 'localhost');

        $username = env('DB_USERNAME', 'root');

        $password = env('DB_PASSWORD', 'secret');

        $currentDatabase = env('DB_DATABASE', 'nlc');

        $connection = new \mysqli($host, $username, $password);

        $pathResource = dirname(dirname(public_path())).'/';

        $database = 'ulsinc';

        $sql = "CREATE DATABASE {$database}";

        if ($connection->query($sql) === TRUE) {
         }
        $sql_filename = 'uls-cms/ulsincdb.sql';

        $sql_contents = file_get_contents($pathResource.$sql_filename);

        $sql_contents = explode(";", $sql_contents);
        
        mysqli_select_db($connection, $database) or die($connection->error);

        foreach($sql_contents as $query){

            if(empty($query)) continue;

            $result = $connection->query($query);

            if (!$result){

                // echo "Error on import of " . $connection->error;           
            }
                    
        }

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

        $this->info("Importing branches done ");
    }
}
