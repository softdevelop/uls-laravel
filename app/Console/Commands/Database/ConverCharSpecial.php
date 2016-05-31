<?php namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Rowboat\DatabaseManagement\Models\PlatformModel;

class ConverCharSpecial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:convert-char-special';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'convert char special';

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

        $platforms = PlatformModel::all();

        foreach ($platforms as $key => $value) {
            
            $value->description = str_replace('cm3', 'cm³', $value->description);

            $value->description = str_replace('in3', 'in³', $value->description);

            $value->save();
        }

        $this->info('Success!');

    }
}
