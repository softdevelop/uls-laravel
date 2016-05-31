<?php
use Rowboat\ContentManagement\Services\PagesService;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
class CmsTest extends TestCase{


    /**
     * [testCleanData description]
     * @author toan
     * @return [type] [description]
     */
     public function testCleanData(){

        $deleteParams = [
            'index' => 'pages'
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
            'index' => 'pages', // index mean schema like mysql
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 1,
                    'analysis'=> [
                        'analyzer'=> [
                            "content" => [
                                "type" => "custom",
                                "tokenizer" => "standard",
                                "filter" => ['lowercase', 'stop', 'kstem'],
                                "char_filters" => ['html_strip']
                            ]
                        ]
                    ]
                ],

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
            'index' => 'pages',
            'type' => 'page',
            'body' => [
                'page' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'title' => [
                            'type' => 'string',
                            'analyzer' => 'content',
                            'include_in_all' => true
                        ],
                        'language' => [
                            'type' => 'string',
                            'include_in_all' => false,
                            'index' => 'not_analyzed'
                            // we are setting index to no_analyzed. This means we are asking Elasticsearch not to analyze the string
                            // this is required to do aggregation effectively
                        ],
                        'region' => [
                            'type' => 'string',
                            'include_in_all' => false,
                            'index' => 'not_analyzed'
                        ],
                        'url' => [
                            'type' => 'string',
                            'include_in_all' => false,
                            'index' => 'no'
                            // we are setting index to no. This means that this field is not searchable but retrivable
                        ],
                        'html' => [
                            'type' => 'string',
                            'analyzer' => 'content',
                            'include_in_all' => true
                        ],

                    ]
                ]
            ]
        ];

        // Update the index mapping
        \RES::indices()->putMapping($params);
    }
    /**
     * [testAddNewDocument description]
     * @author toan
     * @return [type] [description]
     */
    public function testAddNewDocument(){
        $contentObject = ContentModelMongo::find("56c26499d647919e718b4569");
        $html = PagesService::getViewPage($contentObject, false, null, null);
        $title = array_values($contentObject->data['fields'])[0];
        $params = [
            'index' => 'pages',
            'type' => 'page',
            'id' => $contentObject->id,
            'body' => [
                'language' => $contentObject->language,
                'region' => $contentObject->region,
                'title' => $title,
                'url' => $contentObject->url_build,
                'html' => $html,
            ]
        ];

        $response = \RES::index($params);
        $this->assertArrayHasKey('created',$response);
        $this->assertEquals(1, $response['created']);
    }
    /**
     * [testSimpleQuery description]
     * @return [type] [description]
     * @author toan
     */
    public function testSimpleQuery(){
        $params = [
            'index' => 'pages',
            'type' => 'page',
            'from' => 0,
            'size' => 10,
            'body' => [
                'query' => [
                    'match' => [
                        '_all' => 'A Truly Universal Technology'
                    ]
                ]
            ]
        ];

        $response = \RES::search($params);
        $this->assertArrayHasKey('hits',$response);
        $this->assertEquals(1, $response['hits']['total']);
    }

    public function testApiSearch()
    {

        $data = ['text' => 'Universal Laser Systems'];

        $request = $this->post('api/pages/search-pages', $data);

        $request->seeJson(['status' => 1]);
    }

}