<?php

namespace App\Console\Commands\Users;

use Illuminate\Console\Command;
use Rowboat\Users\Models\Mongo\HelpEditorModelMongo;

class AddSortNumberFieldForHelpEditor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:add_sort_number_field_for_help_editor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add sort number field for help editor.';

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

        $helpPages = HelpEditorModelMongo::where('parent_id', '0')->get();

        foreach ($helpPages as $page) {

            $helpTopics = HelpEditorModelMongo::where('parent_id', $page->_id)->orderBy('created_at', 'asc')->get();

            foreach ($helpTopics as $key => $topic) {
                if (isset($topic->sort_number)) continue;
                $topic->sort_number = $key + 1;
                $topic->save();
            }
        }
           
        $this->info('Success!');
    }
}
