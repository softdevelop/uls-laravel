<?php
use Rowboat\ContentManagement\Services\PagesService;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\ContentManagement\Services\DataService;
use Rowboat\TemplateContentManager\Services\TemplateContentManagerService;
use Rowboat\TemplateContentManager\Models\Mongo\TemplateContentManagerModel;
use Rowboat\CmsContent\Services\ParserContentService;

class AutosuggestionTest extends TestCase {
    var $index = 'pages_dev';
    var $type = 'page_suggestion';


    public function testCleanData(){
        
        $deleteParams = [
            'index' => $this->index
        ];
        $response = \RES::indices()->delete($deleteParams);
        $this->assertArrayHasKey('acknowledged',$response);
        $this->assertEquals(1, $response['acknowledged']);

    }

    /**
     * [testCreateIndex test create index]
     * @author toan
     * @return [void]
     */
    public function testCreateIndex(){

        $params = [
            'index' => $this->index,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1,
                ]
            ]
        ];

        $response = \RES::indices()->create($params);
        $this->assertArrayHasKey('acknowledged',$response);
        $this->assertEquals(1, $response['acknowledged']);
    }


    /**
     * [createNewType create new mapping type]
     * @author toan
     * @return [void]
     */
    public function testCreateNewType(){
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => [
                $this->type => [
                    'properties' => [
                        'name' => [
                            'type' => 'string'
                        ],
                        'suggest' => [
                            "type" => 'completion',
                            'index_analyzer' => 'simple',
                            'search_analyzer' => 'simple',
                            'payloads' => true
                        ]
                    ]
                ]
            ]
        ];

        // Update the index mapping
        \RES::indices()->putMapping($params);
    }

    public function putDataToSuggestion($contentObject, $content) {

       $params = [
            'index' => $this->index,
            'type' => 'page_suggestion',
            'body' => [
                'name' => $content,
                'suggest' => [
                    'input' => explode(' ', $content),
                    'output' => $content,
                    "payload" => [ "url" => '/' . $contentObject->language . '-' . $contentObject->region . $contentObject->url_build, 'content_id' => $contentObject->id]
                ]
            ]
        ];
        $response = \RES::index($params);  // create search

    }
    /**
     * [testAddNewDocument description]
     * @author toan
     * @return [type] [description]
     */
    public function testAddNewDocument() {

        $contentObject = ContentModelMongo::find("56c26499d647919e718b4569");

        $html = PagesService::getViewPage($contentObject, false, null, null);

        // Get template 
        $template = TemplateContentManagerModel::find($contentObject->template_id);

        if(empty($template)) return 'No Template'; // return empty at template not exitst 

        $contentTemplate = TemplateContentManagerService::getContentTemplateViewPage($template, $contentObject->language, $contentObject->region);

        $parserContentService = new ParserContentService();

        $fieldsTemplate = TemplateContentManagerService::getAllFieldsTemplateAndBlockInject($contentTemplate, $contentObject->language, $contentObject->region);

        $dataPage = DataService::getDataOfCurrentPage($contentObject->_id);

        $content = $parserContentService->parserContentReView($contentTemplate->content_build, $contentObject->language, $contentObject->region);
        // hook fields page when set value in page
        $dataPage['fields'] = PagesService::hookField($dataPage['fields'], $fieldsTemplate, $contentObject->language, $contentObject->region, $content, $contentObject->_id);

        $page = $contentObject->cmsPage;
        
        $this->putDataToSuggestion($contentObject, $page->name);

        foreach ($dataPage['fields'] as $key => $value) {
                
            if(is_string($value)) {

                $content = strip_tags($value, '');

                $this->putDataToSuggestion($contentObject, $content);
            }
        }
        
    }

    /**
     * [testFST test Finite State Automata]
     * {
     *  "pageSuggest": {
     *      "text": "Truly",
     *     "completion": {
     *        "field": "pageSuggest"
     *     }
     *    }
     *  }
     * @return [type] [description]
     */
    public function testFST(){
        
        $params = [
            'index' => $this->index,
            'body' => [
                'result' => [
                    'text' => 'Home',
                    'completion' => [
                        'field' => 'suggest'
                    ]
                ]
                
            ]
        ];
        $response = \RES::suggest($params);

        $this->assertArrayHasKey('result',$response);
        $this->assertEquals(1, count($response['result'][0]['options']));
    }
    
    public function testApiSearchAutosuggestionPages() {

        $data = ['text' => 'Home'];

        $request = $this->post('api/pages/search-auto-suggestion-pages', $data);
        // die('xx');
        $request->seeJson(['status' => 1]);

    }
}