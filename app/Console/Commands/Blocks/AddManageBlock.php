<?php

namespace App\Console\Commands\Blocks;

use Illuminate\Console\Command;
use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;

class AddManageBlock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blocks:add_manage_block';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add block manager.';

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
        $blocksFolderModel = new BlocksFolderModelMongo();
        $block = $blocksFolderModel->where('parent_id','0')->where('name','Blocks')->first();
        if(!empty($block->toArray())){
            $checkManagerBlock = $blocksFolderModel->where('parent_id',$block->_id)->where('types','managed_block')->count();
            if(!$checkManagerBlock){
                $blocksFolderModel->create(['name' => 'Manager block', 'parent_id' => $block->_id,'types' =>'managed_block' ]);
            }
        }
        $this->info('Success!');

    }
}
