<?php

use Rowboat\AssetsManagement\Models\Mongo\AssetsFileModelMongo;
use Rowboat\AssetsManagement\Services\FileService;

class MapperAttachmentsTest extends TestCase {

    public function testCleanData() {
         $index = env('es_index', 'pages_dev');
        $deleteParams = [
            'index' => $index
        ];
        $response = \RES::indices()->delete($deleteParams);
        $this->assertArrayHasKey('acknowledged',$response);
        $this->assertEquals(1, $response['acknowledged']);

    }

    public function testCreateIndex(){
        $index = env('es_index', 'pages_dev');
        $params = [
            'index' => $index,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0
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
    public function testCreateNewTypeAttachment()
    {
        $index = env('es_index', 'pages_dev');

        $types = ['pdf'];

        foreach ($types as $key => $type) {
                
            $params = [
                'index' => $index,
                'type' => $type,
                'body' => [
                    $type => [
                        'properties' => [
                            'my_attachment' => [
                                'type' => 'attachment',
                                // "path"=> "full",
                                // 'my_attachment' => [
                                //     "fields" => [
                                //         "type"=> "string",
                                //         "term_vector"=>"with_positions_offsets",
                                //         "store"=> true
                                //     ]
                                // ]
                            ]
                        ]
                    ]
                ]
            ];

            \RES::indices()->putMapping($params);
        }
    }

    // /**
    //  * [testAddNewDocument description]
    //  * @author toan
    //  * @return [type] [description]
    //  */
    public function testAddNewAttachment() 
    {
        
        $id ='56d9ff65d64791c2748b457f';
        $asset = AssetsFileModelMongo::find($id);

        $fileService = new FileService;

        $folder = $asset->cmsAssetFolder()->first();
        // if  parent id = '0' set url =''
        if ($folder->parent_id == '0') {
            $url = '';
        } else {
            //set url = $this->name
            $url = $folder->name;
        }
        //get url folder
        $path = $folder->getUrlfolder($folder->_id, $url);

        $path = $path . '/' . $id . '/';

        // $file = file_get_contents(storage_path('app/assets/'.$path.$asset->filename));
        // $file = $fileService->get($asset->filename, $path, 'assets');
        $file = file_get_contents(storage_path('vls_platform.pdf'));
        $file = base64_encode($file);

        $params = [
            'index' => env('es_index', 'pages_dev'),
            'type' => 'pdf',
            'id' => $id,
            'body' => [
                // 'name' => $asset->filename,
                // 'title' => $asset->name,
                // 'date' => $asset->created_at,
                'my_attachment' => $file,
                // 'content_type' => 'application/pdf',
            ]
        ];

        $response = \RES::index($params);
        $this->assertArrayHasKey('created',$response);
        $this->assertEquals(1, $response['created']);      
    }

    public function testSimpleQuery()
    {
        
        $params = [
            'index' => env('es_index', 'pages_dev'),
            'type' => 'pdf',
            'from' => 0,
            'size' => 10,
            'body' => [
                'query' => [
                    "match" => [
                        "my_attachment" => "Flexibility for Growing Businesses"
                    ]
                    // 'query_string' => ['query' => 'freestanding laser platforms offer increased maximum laser source power levels and larger working areas than the desktop models']
                ]
            ]
        ];

        $response = \RES::search($params);

        $this->assertArrayHasKey('hits',$response);
        $this->assertEquals(1, $response['hits']['total']);
    }
}