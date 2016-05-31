<?php namespace App\Http\Controllers;

use Rowboat\BlocksManagement\Models\Mongo\BlocksContentModelMongo;
use Rowboat\BlocksManagement\Models\Mongo\BlocksModelMongo;
use Rowboat\TemplateContentManager\Models\Mongo\ContentTemplateModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\CmsContent\Services\ParserContentService;
use Rowboat\BlocksManagement\Services\BlocksService;
use Rowboat\ContentManagement\Services\PagesService;
use Rowboat\Ticket\Services\TicketService;
use Rowboat\Ticket\Models\TypeModel;
use App\Models\Mongo\DashboardModelMongo;

class DashboardController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        $ticketModel = new TicketModel();
        $ticketService = new TicketService();
        $pageService = new PagesService();
        $typeModel = new TypeModel();

        $urlMap = $pageService->getUrlMap();

        $tickets_new = $ticketModel->getRequiredByMeTickets(\Auth::user());
        $tickets_new = $ticketModel->formatDashboard($tickets_new,$urlMap);

        $tickets_allopen = $ticketModel->getAllOpenTickets(\Auth::user());
        $ticketsAvailable = $tickets_allopen;
        $tickets_allopen = $ticketModel->formatDashboard($tickets_allopen,$urlMap);

        $states = $ticketModel::$states;

        $pageOverview = $pageService->getPageOverview();

        $ticketTypes = $typeModel->getTypeDashboard($ticketsAvailable);

        $userDashboardViews = DashboardModelMongo::where('user_id', \Auth::user()->id)->orderBy('sort_order', 'asc')->get();

        return view('dashboard', compact('tickets_new', 'tickets_allopen', 'states', 'pageOverview', 'ticketTypes', 'userDashboardViews'));
    }

    public function generateUpdateTemplate()
    {

        $parserContentService = new ParserContentService();

        $contentTemplate = ContentTemplateModelMongo::all();

        foreach ($contentTemplate as $key => $value) {

                $content = $value->content;
                $fields = $sections = $extends = $blocks = $links = $assets = [];

                $parserContentService->parserContentConfig($content, $fields, $sections, $extends, $blocks, $links, $assets);

                BlocksService::$blockInjectIds = [];
                BlocksService::$blockInjectManagerIds = [];

                if(!empty($blocks)){
                    // brower block inject then get all injects block chilren
                    foreach ($blocks as $key => $item) {

                        BlocksService::recursiveGetIdBlockInjectInBlock($item, $value->language, $value->region, $item);
                    }
                }
                $value->injects = array_unique(BlocksService::$blockInjectIds);
                $value->inject_manageds = array_unique(BlocksService::$blockInjectManagerIds);

                $value->save();
        }

        return 'success';
    }
    public function getGenerateBuild()
    {
        // get all template content
        $contentBlock = BlocksContentModelMongo::all();

        foreach ($contentBlock as $key => $value) {
            $value->content_build = $value->content;
            if (isset($value->fields) && isset($value->content)) {

                foreach ($value->fields->toArray() as $key => $field) {
                    // update content build template
                    $value->content_build = str_replace('$' . $field['variable'], '$_' . $value->base_id  . '_' . $field['variable'], $value->content_build);

                }
            }

            $value->save();

        }
        // event generate colection build template
        event(new \Rowboat\TemplateContentManager\Events\Template\GenerateBuildTemplate());        
        return 'success';
    }

    public function getDemoRockmongo()
    {
     \DB::connection('mongodb')->enableQueryLog();
        $query = ContentModelMongo::
            raw(function ($collection){
                $collection->update(
                    [
                        "data.fields._56df3029d64791ee778b458d_field_loop._56ce48f2d6479193388b4567_field_mainContent" => "Hi"
                    ],
                    [
                        '$unset'=> [
                            'data.fields._56df3029d64791ee778b458d_field_loop.$._56ce48f2d6479193388b4567_field_mainContent' => ''
                        ]
                    ])
                ;
            });

        $queries = \DB::connection('mongodb')->getQueryLog();
        dd($queries);
    }
    public function getGenerateContentBlockBuild()
    {
        // event generate content build block
        event(new \Rowboat\BlocksManagement\Events\Block\GenerateContentBlockBuild());
        return 'success';
    }

    public function getTestS3()
    {
        // $mimetype = \Storage::mimeType('assets/huy/app.css');
        // var_dump($mimetype);die;

        $disk = \Storage::disk('s3');
        $type = $disk->getMetadata('assets/css/56c5905ddf35760c3a8b4569/main.css');
        var_dump($type);die;
    }

    public function testSendMail()
    {
        \Mail::send('emails.test', ['user' => \Auth::user()], function ($m) {
            $m->to('thanhhuy.cth53@gmail.com', 'test')->subject('Your Reminder!');
        });
        die('done');
    }

    public function selectTypeToShowDashboard()
    {
        $typeModel = new TypeModel();
        $user = \Auth::user();

        $config = \DB::table('dashboard_type')->where('user_id',$user->id)->get();

        $typeException = array_fetch($config,'type_id');

        $types = $typeModel->whereIn('id',$typeException)->get();

        $types = $typeModel->filterTypeUnselected($types);

        return view('dashboard.selectTypeTicket',compact('types'));
    }

    /**
     * [getTablename description]
     * 
     * @return [type] [description]
     */
    public function getTablename()
    {

        $command = 'mongoexport --db uls_test --collection cms.templates.content --out templates.json';
        $results = shell_exec($command);

        $content = '';
        $array = [];

        $lines = file('templates.json');
        $index = -1;
        $content .= "\n/** cms.templates.content indexes **/\ndb.getCollection(\"cms.templates.content\").ensureIndex({\"_id\": NumberInt(1)});\n";
        foreach ($lines as $key => $line) {
            $index ++;
            $line = json_decode($line, true);
            $arrayMap = $this->getFieldForeach($line);

            $string = call_user_func('json_encode', $line);
            $string = strtr($string, $arrayMap);
            $content .= "db.getCollection(\"cms.templates.content\").insert(".$string.");\n";
        }

        if (file_exists('templates.json')) {
            unlink('templates.json');
        }
        $content = $this->json_format($content);
        \Storage::put('test.js', $content);
    }

    public function getFieldForeach(&$data, &$index = 0, &$arrayMap = [])
    {

        foreach ($data as $key => &$line) {
            if (is_array($line) && !isset($line['$oid']) && !isset($line['$date']) && !isset($line['$numberLong'])) {
                
                $this->getFieldForeach($line, $index, $arrayMap);
            } else {
                if (isset($line['$oid'])) {
                    $index++;
                    $arrayMap["\""."%{'Mongo_Param_'" .$index. "}"."\""] = 'ObjectId("'.$line['$oid'].'")';
                    $line = "%{'Mongo_Param_'".$index."}";
                } elseif(isset($line['$date'])) {
                    $index++;
                    $arrayMap["\""."%{'Mongo_Param_'" .$index. "}"."\""] = '"'.preg_replace('/\+\w+/', 'Z', $line['$date']).'"';
                    $line = "%{'Mongo_Param_'".$index."}";
                } elseif (isset($line['$numberLong'])) {
                    $index++;
                    $arrayMap["\""."%{'Mongo_Param_'" .$index. "}"."\""] = 'NumberLong(' . $line['$numberLong'] . ')';
                    $line = "%{'Mongo_Param_'".$index."}";
                } elseif (gettype($line) == 'integer') {
                    $index++;
                    $arrayMap["\""."%{'Mongo_Param_'" .$index. "}"."\""] = 'NumberInt(' . $line . ')';
                    $line = "%{'Mongo_Param_'".$index."}";
                } elseif (method_exists($line, "__toString")) {
                    $line = $line->__toString();
                }
            }

        }

        return $arrayMap;
    }

    function json_format($json)
    {
        $tab = "  ";
        $new_json = "";
        $indent_level = 0;
        $in_string = false;

        $len = strlen($json);

        for($c = 0; $c < $len; $c++)
        {
            $char = $json[$c];
            switch($char)
            {
                case '{':
                case '[':
                    if(!$in_string)
                    {
                        $new_json .= $char . "\n" . str_repeat($tab, $indent_level+1);
                        $indent_level++;
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case '}':
                case ']':
                    if(!$in_string)
                    {
                        $indent_level--;
                        $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case ',':
                    if(!$in_string)
                    {
                        $new_json .= ",\n" . str_repeat($tab, $indent_level);
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case ':':
                    if(!$in_string)
                    {
                        $new_json .= ": ";
                    }
                    else
                    {
                        $new_json .= $char;
                    }
                    break;
                case '"':
                    if($c > 0 && $json[$c-1] != '\\')
                    {
                        $in_string = !$in_string;
                    }
                default:
                    $new_json .= $char;
                    break;
            }
        }

        return $new_json;
    }
}
