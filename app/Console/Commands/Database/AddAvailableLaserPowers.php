<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Rowboat\DatabaseManagement\Models\PlatformModel;
class AddAvailableLaserPowers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'availableLaserPowers:import_availablelaserpowers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add data available laser powers.';

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
        $this->info('Start available !!!');

        $path =base_path();

        \DB::table('available_system')->delete();

        \Excel::load($path.'/availablelaserpowers_336a995458-2.xlsx', function($reader) use (&$isError) {
            $rows = $reader->get()->toArray();
            $litlimit =[];
            foreach ($rows as $key => $row) {
                if($row['single_laser_system'] == null && $row['dual_laser_system'] == null && $row['fiber_lasers'] == null ) continue;
                    $data = [];
                    $data['single_laser_system'] =  $row['single_laser_system'];
                    $data['dual_laser_system'] =  $row['dual_laser_system'];
                    $data['fiber_lasers'] =  $row['fiber_lasers'];
                    \DB::table('available_system')->insert($data);
            }
        });

        $this->info('end !!!');
    }
}
