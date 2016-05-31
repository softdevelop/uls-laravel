<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\ContentManagement\Services\PagesService;

use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\ContentManagement\Http\Controllers\Api\PagesController;
use Rowboat\Ticket\Models\Mongo\TicketModelMongo;
use Rowboat\Users\Models\UserModel;

class CreateTicketChildPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:create_ticket_child_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Ticket child pages';

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
        $ticketModel = new TicketModel();
        $ticketModelMongo = new TicketModelMongo();

        $types = ['page_html','page_content','page_visual','page_seo','page_build'];

        $dataType = ['page_html' => true,'page_content' => true,'page_visual' => true,'page_seo' => true,'page_build' => true];

        $contentModelMongo = new ContentModelMongo();
        $pageController = new PagesController();

        $contents = $contentModelMongo->where('language','en')->where('region',null)->whereNull('copyID')->get();
        foreach ($contents as $content) {

            $ticket = $ticketModel->find($content->ticket_id);

            if($ticket != null) {
                $ticketMongo = $ticketModelMongo->where('ticket_id',intval($ticket->id))->first();

                $childs = $ticketModel->where('base_id', $ticket->id)->whereIn('type',$types)->get();

                $childType = array_fetch($childs->toArray(),'type');

                if(in_array('page_html', $childType)) {

                    $dataType['page_html'] = false;

                }
                if(in_array('page_content', $childType)){

                    $dataType['page_content'] = false;

                }
                if(in_array('page_visual', $childType)){

                    $dataType['page_visual'] = false;

                }
                if(in_array('page_seo', $childType)){

                    $dataType['page_seo'] = false;
                }

                if(in_array('page_build', $childType)){

                    $dataType['page_build'] = false;
                }

                $dataTicket = $ticket->toArray();

                $dataTicket['assign_id'] = null;
                $dataTicket['percent_complete'] = 0;
                $dataTicket['description'] = $ticketMongo->notes;
                $dataTicket['user_id'] = intval($ticket->user_id);
                unset($dataTicket['id']);
                unset($dataTicket['url']);
                unset($dataTicket['content_id']);

                self::addTicketChildPage($dataType, $dataTicket, $ticket->id);   
            }

                     
        }

        $this->info('Success!');
    }

    public static function addTicketChildPage($data, $dataTicket, $ticketParent)
    {
        $sender = UserModel::find($dataTicket['user_id']);

        if(isset($data['page_html']) && $data['page_html']) {
            $ticketModel = new TicketModel();

            $dataHtml = $dataTicket;
            $dataHtml['type'] = 'page_html';
            $dataHtml['base_id'] = $ticketParent;
            $dataHtml['ticketType'] = 'page_html';           

            $html = $ticketModel->createTicket($sender, $dataHtml);
        }

        if(isset($data['page_content']) && $data['page_content']) {
            $ticketModel = new TicketModel();
            
            $dataContent = $dataTicket;
            $dataContent['type'] = 'page_content';
            $dataContent['base_id'] = $ticketParent;
            $dataContent['ticketType'] = 'page_content';

            $content = $ticketModel->createTicket($sender, $dataContent);
        }

        if(isset($data['page_visual']) && $data['page_visual']) {
            $ticketModel = new TicketModel();
            
            $dataVisual = $dataTicket;
            $dataVisual['type'] = 'page_visual';
            $dataVisual['base_id'] = $ticketParent;
            $dataVisual['ticketType'] = 'page_visual';

            $visual = $ticketModel->createTicket($sender, $dataVisual);
        }

        if(isset($data['page_seo']) && $data['page_seo']) {
            $ticketModel = new TicketModel();
            
            $dataSeo = $dataTicket;
            $dataSeo['type'] = 'page_seo';
            $dataSeo['base_id'] = $ticketParent;
            $dataSeo['ticketType'] = 'page_seo';

            $seo = $ticketModel->createTicket($sender, $dataSeo);
        }

        if(isset($data['page_build']) && $data['page_build']) {
            $ticketModel = new TicketModel();
            
            $dataBuild = $dataTicket;
            $dataBuild['type'] = 'page_build';
            $dataBuild['base_id'] = $ticketParent;
            $dataBuild['ticketType'] = 'page_build';

            $seo = $ticketModel->createTicket($sender, $dataBuild);
        }
    }
}
