<?php

namespace App\Console\Commands\Types;

use Illuminate\Console\Command;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Ticket\Models\TypeModel;

use Rowboat\Ticket\Models\Mongo\TicketModelMongo;
use Rowboat\Users\Models\UserModel;

class AddColumnParentToTypeTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'type:update_child_for_type_create_new_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update child parent for type create new pages';

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
        
        $typeModel = new TypeModel();

        $typeCreateNewPage = $typeModel->where('alias','create_new_page')->first();

        $childType = ['page_html','page_content','page_visual','page_seo','page_build'];

        if($typeCreateNewPage) {
            $childs = $typeModel->whereIn('alias',$childType)->get();
            foreach ($childs as $type) {
                $type->parent_id = $typeCreateNewPage->id;
                $type->save();
            }
        }

        $this->info('Success!');
    }
}
