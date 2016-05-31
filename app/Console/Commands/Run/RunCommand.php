<?php

namespace App\Console\Commands\Run;

use Illuminate\Console\Command;

class RunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run command project';

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
        $this->info('Start run command !!!');

        require base_path() .'/app/Console/Config.php';

        $echo = $this->getOutput();

        foreach ($commands as $key => $value) {

            $checkHasRunCommand = \DB::table('run_command')->where('name', $value)->count();
            if($checkHasRunCommand == 0) {
                $echo->writeln('<info>Start command:  </info>' . $value);
                \Artisan::call($value);
                \DB::table('run_command')->insert(['name' => $value]);
            }
        }

        $this->info('run command done');
    }
}
