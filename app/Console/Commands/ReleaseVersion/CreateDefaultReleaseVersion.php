<?php
namespace App\Console\Commands\ReleaseVersion;

use Illuminate\Console\Command;
use Rowboat\ContentManagement\Models\Mongo\ReleaseVersionModelMongo;

class CreateDefaultReleaseVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'releaseversion:create_default_release_version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default release version 1.0 into table cms.release-version';

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
        $releaseVersionModelMongo = new ReleaseVersionModelMongo();

        //check if exist release version 1.0 then don't create release version 1.0
        $check = $releaseVersionModelMongo->where('version',1.0)->count();
        if($check == 0) {
            //create release 1.0
            $releaseVersionModelMongo->create([
                                                'version' => 1.0, 
                                                'description' => 'Release Version 1.0', 
                                                'active_production' => 'active',
                                                'active_demo' => 'active'
                                            ]);
        } else {
            $this->info('release version 1.0 exist!');
        }
        $this->info('Success!');

    }
}
