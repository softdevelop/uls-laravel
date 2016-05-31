<?php namespace Rowboat\ContentManagement\Services;

use App\Models\LanguageModel;
use App\Models\MarketSegmentModel;

use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\ContentManagement\Models\Mongo\RevisionModelMongo;
use Rowboat\ContentManagement\Models\Mongo\UrlModelMongo;

use App\Models\Mongo\SeoContentModel;
use App\Models\Mongo\TemplateManagerModelMongo;
use App\Models\RegionModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Rowboat\Ticket\Jobs\Ticket\Create\CreateTicketEmail;
use Rowboat\Ticket\Jobs\Ticket\Create\CreateTicketNotification;
use Rowboat\Ticket\Models\TicketModel;

class PagesService
{
    use DispatchesJobs;

    /**
     * Get page to show page tree
     * @param  integer $parent_id ParentID
     * @return Array              Array pages
     */
    public static function  getPagesTree($parent_id = '0')
    {
        $pageModelMongo = new PageModelMongo();

        $contentModelMongo = new ContentModelMongo();

        $dateNow = new \DateTime();

        $timeNow = $dateNow->format('Y-m-d H:i:s');

        $items = $pageModelMongo::where('parent_id', $parent_id)->orderBy('_id', 'asc')->get();

        /* Foreach pages to add data for child pages  */
        foreach ($items as &$item) {
            //Get page expand
            $contents = $contentModelMongo->where('page_id', $item->_id)->where('status','<>','replaced')->get();
            //Status of page consolidated
            $status = array_fetch($contents->toArray(), 'status');

            if (in_array("draft", $status)) {

                $item->status = 'draft';

            } else if (in_array("live", $status)) {

                $item->status = 'live';

            } else {

                $item->status = 'retired';
            }

            $item->region = 0;

            $languages = [];

            foreach ($contents as $key => $content) {
                //Region of page consolidated
                //    $contentModelMongo = new ContentModelMongo();
                $contentModelMongo = new ContentModelMongo();
                if(!empty($content->copyID)){
                      $contents[$key]['version']=1;
                } else{
                    $contents[$key]['version']=0;
                }

                if ($content->region != null) {

                    $item->region = $item->region + 1;
                }
                $languages[] = $content->language;
                //Get due date pages
                $ticket = TicketModel::find($content->ticket_id);

                if (!empty($ticket->due_date)) {

                    if (strtotime($timeNow) >= strtotime($ticket->due_date)) {

                        $contents[$key]->due_date = 'n/a';

                    } else {

                        $contents[$key]->due_date = $ticket->due_date;
                    }
                }

                if ($ticket->status != 'closed') {
                    if (empty($item->due_date)) {
                        if (strtotime($timeNow) <= strtotime($ticket->due_date)) {
                            $item->due_date = $ticket->due_date;
                        }
                    } else {
                        if (strtotime($ticket->due_date) < strtotime($item->due_date) && strtotime($timeNow) <= strtotime($ticket->due_date)) {
                            $item->due_date = $ticket->due_date;
                        }
                    }
                }
            }

            $languages = array_unique($languages);
            $item->contents = $contents;
            $item->language = count($languages);

            $hasSubFolder = $pageModelMongo->where('parent_id', $item->id)->count();
            /* If page has child pages */
            if ($hasSubFolder) {
                /* Add child page to array children */
                $item->children = self::getPagesTree($item->id);
                $item->folder = true;
            }
           /*  $item->hideCheckbox = true;*/
            /*If pages have children or page have parent_id == 0*/
            /* Set data to show page tree */
            $item->title = $item->name;
            $item->key = $item->id;
            /* delete */
            unset($item->id);

        }
        return $items;
    }
    // public function getLabelsTree($parrentId = null)
    // {

    //     $labels = PageModelMongo::$labels;

    // }
    /**
     * Get page to show page tree
     * @param  integer page id
     * @return Array              Array pages
     */
    public static function getPageTree($pageId)
    {
        $pageModelMongo = new PageModelMongo();
        $contentModelMongo = new ContentModelMongo();
        /*dd( $pageModelMongo->all()->toArray());die;*/
        $item = $pageModelMongo::find($pageId);
        //Get page expand
        $contents = $contentModelMongo->where('page_id', $item->_id)->where('status','<>','replaced')->get();
        //Status of page consolidated
        $status = array_fetch($contents->toArray(), 'status');
        if (in_array("draft", $status)) {
            $item->status = 'draft';
        } else if (in_array("live", $status)) {
            $item->status = 'live';
        } else {
            $item->status = 'retired';
        }

        $item->region = 0;
        $languages = [];
        foreach ($contents as $key => $content) {
            //Region of page consolidated
            $revisions=$contentModelMongo->where('copyID', $content['_id'])->get();
            $contents[$key]['version'] = count($revisions);
            if ($content->region != null) {
                $item->region = $item->region + 1;
            }
            $languages[] = $content->language;
            //Get due date pages
            $ticket = TicketModel::find($content->ticket_id);
            $content->due_date = $ticket->due_date;

            if ($ticket->status != 'approved' && $ticket->status != 'closed') {
                if (empty($item->due_date)) {
                    $item->due_date = $ticket->due_date;
                } else {
                    if (strtotime($ticket->due_date) < strtotime($item->due_date)) {
                        $item->due_date = $ticket->due_date;
                    }
                }
            }
        }
        $item->contents = $contents;
        $languages = array_unique($languages);
        $item->language = count($languages);
        /* Set data to show page tree */
        $item->title = $item->name;
        // $item->hideCheckbox = true;
        $item->key = $item->id;
        unset($item->id);
        return $item;
    }
    /**
     * Show all folder on parent page
     * @return Array
     */
    public static function getChildPagesById($id)
    {
        /* Search child pages of Page selected with page id */
        $items = $items = \DB::table('pages')->where('parent_id', $id)->orderBy('id', 'asc')->get();
        /* Foreach pages to add data for child pages  */
        foreach ($items as $item) {
            $item->title = $item->name;
            $item->key = $item->id;

            unset($item->id);
            unset($item->name);
        }
        return $items;
    }

    /**
     * get menu page
     * @param  integer $parent_id
     * @return object
     */
    public static function getMenuPage($parent_id = 0)
    {
        $page = new PageModel;

        $menu = '';
        $menu .= "<ul>";

        if (empty($page->parent_id)) {
            $page->parent_id = 0;
        }

        $items = PageModel::where('parent_id', $parent_id)->get();

        foreach ($items as $item) {
            ($item->parent_id == '0') ? $menu .= "<li class='has-sub'>" : $menu .= "<li>";
            $menu .= "<a class='sub-0' href='/uls-page/$item->id'>" . $item->name . "</a>";
            $subMenu = PageModel::where('parent_id', $item->id)->count();

            if ($subMenu) {
                $menu .= $this->getMenuPage($item->id);
            }
            $menu .= "</li>";
        }
        $menu .= "</ul>";

        return $menu;
    }
    public static function getPagesById($content_id)
    {
        $SeoContentModel = new SeoContentModel();
        $urlModelMongo = new UrlModelMongo();
        $contentModelMongo = new contentModelMongo();
        $pageData = $SeoContentModel->where('content_id', $content_id)->first();
        $content = $contentModelMongo->find($content_id);
        $url = $urlModelMongo->find($content['url_id']);
        if (empty($pageData)) {
            $pageData = $SeoContentModel->saveSeoData($content_id, $url['route']);
        } else {
            if ($pageData['status'] == 0 || $url['route'] != $pageData['url']) {
                $pageData->delete();
                $pageData = $SeoContentModel->saveSeoData($content_id, $url['route']);
            }
        }
        $page = PageModelMongo::find($content['page_id']);
        $pageData['name'] = $page['name'];
        return $pageData;

    }
    /**
     * getTemplateOfPage description
     * @param  int $pageId [description]
     * @return Object      [description]
     */
    public static function getTemplateOfPage($pageId)
    {
        return ContentModelMongo::select('template_id')->where('page_id', $pageId)->get()->toArray()[0]['template_id'];
    }

    public function getInfomationPageToEdit($id)
    {
        /* Get all template */
        $templateModel = new TemplateManagerModelMongo;
        $template_lists = TemplateManagerModelMongo::all();

        /* Get lists image of template with id template */
        $listsIdWithImageNameOfTemplate = TemplateManagerService::getListsTemplateIdWithImageOfTemplate();

        /*Get lists position with imange name of position */
        $positionIdWithImageName = TemplateManagerService::getListsIdWithImageNameOfPosition();

        /* Get page and template */
        $page = PageModel::find($id);
        if ($page == null) {
            abort(404);
        }
        $pages_map = PagesMap();

        $templateIdOfPage = PagesService::getTemplateOfPage($page['id']);

        /* Get content of page */
        $contentMongo = new ContentModelMongo;
        $contents = $contentMongo->getContentByPageId($page->id)->toArray();

        /* If page is exists */
        if (!empty($page)) {
            /* Get lists region selected */
            $region_selected = $page->regions->where('active', 1)->lists('name', 'id')->all();
            /* Get lists region execute region selected */
            $region_unselected = RegionModel::whereNotIn('id', array_keys($region_selected))->where('active', 1)->lists('name', 'id')->all();

            /* Get lists language selected */
            $language_selected = $page->languages->where('active', 1)->lists('name', 'id')->all();
            /* Get lists language execute language selected */
            $language_unselected = LanguageModel::whereNotIn('id', array_keys($language_selected))->where('active', 1)->lists('name', 'id')->all();

            /* Get lists marketsegment selected */
            $marketSegment_selected = $page->marketsegments->where('active', 1)->lists('name', 'id')->all();
            /* Get lists marketsegment execute marketsegment selected */
            $marketSegment_unselected = MarketSegmentModel::whereNotIn('id', array_keys($marketSegment_selected))->where('active', 1)->lists('name', 'id')->all();
            $page['dateLiveBy'] = (new \DateTime($page['dateLiveBy']))->format('m/d/Y');
            $page['dateAvailable'] = (new \DateTime($page['dateAvailable']))->format('m/d/Y');
            $page['toDate'] = (new \DateTime($page['toDate']))->format('m/d/Y');

            $list_content = [];

            $tempId = $contents[0]['template_id'];
            foreach ($template_lists as $template) {
                $position = array_flip(array_fetch($template->sections, 'variable'));
                $position = array_map(function ($v) {
                    return "";
                }, $position);
                if ($template->_id != $tempId) {
                    $list_content[$template->_id] = $position;
                } else {
                    $list_content[$contents[0]['template_id']] = array_intersect_key(array_merge($position, $contents[0]['content']), $position);
                }
            }

            //get field merge to template
            $templateOfPage = $templateModel->find($contents[0]['template_id']);
            if ($templateOfPage) {
                $getFields = array_flip(array_fetch($templateOfPage['fields'], 'variable'));
                $getFields = array_map(function ($v) {
                    return "";
                }, $getFields);
                $contents[0]['field'] = array_intersect_key(array_merge($getFields, $contents[0]['field']), $getFields);
            }

        }

        return ['page' => $page,
            'region_unselected' => $region_unselected,
            'region_selected' => $region_selected,
            'language_unselected' => $language_unselected,
            'language_selected' => $language_selected,
            'marketSegment_unselected' => $marketSegment_unselected,
            'marketSegment_selected' => $marketSegment_selected,
            'contents' => $contents,
            'template_lists' => $template_lists,
            'listsIdWithImageNameOfTemplate' => $listsIdWithImageNameOfTemplate,
            'positionIdWithImageName' => $positionIdWithImageName,
            'templateIdOfPage' => $templateIdOfPage,
            'list_content' => $list_content,
        ];
    }

    public function checkNamePage($name, $parent_id)
    {
        $pageModelMongo = new PageModelMongo();
        $check = $pageModelMongo->where('parent_id', $parent_id)->where('name', $name)->count();
        return $check;
    }

    public function store($data)
    {
        $pageModelMongo = new PageModelMongo();
        $urlModelMongo = new UrlModelMongo();
        $ticketModel = new TicketModel();
        $contentModelMongo = new ContentModelMongo();

        $status = 0;
        if (empty($data['parent_id'])) {
            $data['parent_id'] = '0';
        }
        $check = $this->checkNamePage($data['name'], $data['parent_id']);
        if ($check) {
            $result['status'] = $status;
            return $result;
        }

        //Add page
        $page_id = $pageModelMongo->addPage($data['name'], $data['parent_id']);

        //Add URL
        $parent = $pageModelMongo->find($data['parent_id']);
        if (empty($parent)) {
            $route = '/' . str_replace(' ', '-', strtolower($data['name']));
        } else {
            $route = '/' . str_replace(' ', '-', strtolower($parent->name)) . '/' . str_replace(' ', '-', strtolower($data['name']));
        }
        $url = $urlModelMongo->addUrl($page_id, $route, $live = false);

        //Add Ticket
        $data['requestDate'] = str_replace('-', '/', $data['requestDate']);

        $data['requestDate'] = date('Y-m-d H:i:s', strtotime($data['requestDate']));

        $dataTicket = ['title' => $data['name'], 'type' => 'create_new_page', 'description' => $data['description'], 'url' => \URL::to($route), 'due_date' => $data['requestDate'], 'priority' => 'high'];

        if (!empty($data['files_id'])) {
            $dataTicket['files_id'] = $data['files_id'];
        }

        $ticket = $ticketModel->createTicket(\Auth::user(), $dataTicket);

        if (!empty($ticket->id)) {
            $this->dispatch(new CreateTicketNotification(\Auth::user(), $ticket));
            $this->dispatch(new CreateTicketEmail(\Auth::user(), $ticket));
        }

        $ticket_id = $ticket->id;
        // $arrayTicketID[0] = $ticket_id;
        //Add Content
        $content = $contentModelMongo->addContent($page_id, $status = 'draft', $language = 'en', $region = null, $ticket_id, $url->_id);
        $result['status'] = 1;
        $result['page'] = $this->getPageTree($page_id);
        return $result;
    }
    public function requestTranslation($data)
    {
        $pageModelMongo = new PageModelMongo();
        $urlModelMongo = new UrlModelMongo();
        $contentModelMongo = new ContentModelMongo();

        //route url
        $data['parent_name'] = $data['parent_name'] == 'root' ? '' : '/'.$data['parent_name'];

        $route = str_replace(' ', '-', strtolower($data['parent_name'])) . '/' . str_replace(' ', '-', strtolower($data['name']));

        $data['requestDate'] = str_replace('-', '/', $data['requestDate']);

        $data['requestDate'] = date('Y-m-d H:i:s', strtotime($data['requestDate']));

        foreach ($data['languages'] as $key => $value) {
            //Add URL
            $url = $urlModelMongo->addUrl($data['_id'], $route, $live = false);

            //Add Ticket
            $routeTicket = '/'.$value.'-us'.$route;

            $dataTicket = ['title' => $data['name'], 'type' => 'create_new_page', 'description' => $data['description'], 'url' => \URL::to($routeTicket), 'due_date' => $data['requestDate'], 'priority' => 'high'];
            if (!empty($data['files_id'])) {
                $dataTicket['files_id'] = $data['files_id'];
            }

            $ticketModel = new TicketModel();
            $ticket = $ticketModel->createTicket(\Auth::user(), $dataTicket);

            if (!empty($ticket->id)) {
                $this->dispatch(new CreateTicketNotification(\Auth::user(), $ticket));
                $this->dispatch(new CreateTicketEmail(\Auth::user(), $ticket));
            }

            $ticket_id = $ticket->id;
            //Add Content
            $content = $contentModelMongo->addContent($data['_id'], $status = 'draft', $value, null, $ticket_id, $url->_id);
        }
        $result['status'] = 1;
        $result['page'] = $this->getPageTree($data['_id']);
        return $result;
    }

    public function requestRegion($data)
    {
        $pageModelMongo = new PageModelMongo();
        $contentModelMongo = new ContentModelMongo();
        $urlModelMongo = new UrlModelMongo();

        $parent = $pageModelMongo->find($data['parent_id']);
        $data['parent_name'] = $data['parent_name'] == 'root' ? '' : '/' . $data['parent_name'];

        $route = str_replace(' ', '-', strtolower($data['parent_name'])) . '/' . str_replace(' ', '-', strtolower($data['name']));

        //Update table cms.pages
        $pageModelMongo->updatePage($data['_id'], ['parent_id' => $data['parent_id']]);

        $data['requestDate'] = str_replace('-', '/', $data['requestDate']);

        $data['requestDate'] = date('Y-m-d H:i:s', strtotime($data['requestDate']));

        foreach ($data['regions'] as $key => $value) {
            $route = '/'.$data['language'].'-'.$value.$route;
            //Add Ticket
            $dataTicket = ['title' => $data['name'], 'type' => 'create_new_page', 'description' => $data['description'], 'url' => \URL::to($route), 'due_date' => $data['requestDate'], 'priority' => 'high'];

            if (!empty($data['files_id'])) {
                $dataTicket['files_id'] = $data['files_id'];
            }

            $ticketModel = new TicketModel();
            $ticket = $ticketModel->createTicket(\Auth::user(), $dataTicket);

            if (!empty($ticket->id)) {
                $this->dispatch(new CreateTicketNotification(\Auth::user(), $ticket));
                $this->dispatch(new CreateTicketEmail(\Auth::user(), $ticket));
            }

            $ticket_id = $ticket->id;

            //Add content
            $content = $contentModelMongo->addContent($data['_id'], $status = 'draft', $data['language'], $value, $ticket_id, $data['url_id']);

            // }
        }
        $result['status'] = 1;
        $result['page'] = $this->getPageTree($data['_id']);
        return $result;
    }

    public function requestRevision($data)
    {
        //Add ticket
        $contentModelMongo = new ContentModelMongo();
        $ticketModel = new TicketModel();

        $content = $contentModelMongo->find($data['content_id']);

        if ($content == null) {
            abort(404);
        }

        if (!empty($data['parent_name'])) {
            $route = '/' . str_replace(' ', '-', strtolower($data['parent_name'])) . '/' . str_replace(' ', '-', strtolower($data['name']));
        } else {
            $route = '/' . str_replace(' ', '-', strtolower($data['name']));
        }

        $data['requestDate'] = str_replace('-', '/', $data['requestDate']);

        $data['requestDate'] = date('Y-m-d H:i:s', strtotime($data['requestDate']));

        $dataTicket = [
                        'title' => $data['name'],
                        'type' => 'page_revision',
                        'description' => $data['description'],
                        'url' => \URL::to($route),
                        'due_date' => $data['requestDate'],
                        'priority' => 'high',
                        'ticketType' => 'page'
                    ];

        if (!empty($data['files_id'])) {
            $dataTicket['files_id'] = $data['files_id'];
        }

        $ticket = $ticketModel->createTicket(\Auth::user(), $dataTicket);

        if (!empty($ticket->id)) {
            $this->dispatch(new CreateTicketNotification(\Auth::user(), $ticket));
            $this->dispatch(new CreateTicketEmail(\Auth::user(), $ticket));
        }

        // $arrayId[0] = $ticket->id;
        // /*$arrayId=$content->ticket_id;*/
        // //Update content
        // foreach ($content->ticket_id as $key => $value) {
        //     array_push($arrayId, $value);
        // }
        // $content->ticket_id = $arrayId;
        // $status = $content->save();

        $contentNew=$content;
        $contentNew->copyID=$contentNew->_id;
        $contentNew->status='Not Started';
        $contentNew->ticket_id = $ticket->id;
        unset($contentNew->_id);
        unset($contentNew->updated_at);
        unset($contentNew->created_at);
        $contentModelMongo->create($contentNew->toArray());
        $result['status'] = 1;
        $result['page'] = $this->getPageTree($data['_id']);
        return $result;
    }
}
