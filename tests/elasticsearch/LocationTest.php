<?php
class LocationTest extends TestCase{
    var $index = 'locations';
    var $type = 'location';
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
                        'location' => [
                            "type" => 'geo_shape',
                            "tree"=> "quadtree",
                             "precision"=> "1km"
                        ]
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
    public function testAddNewLocations(){
        $locations = [
            [
                'name'=> 'chicago',
                'lat' => 41.878,
                'lon' => -87.629,
                'radius' => '100km'
            ],
            [
                'name'=> 'newyork',
                'lat' => 40.714,
                'lon' => -74.005,
                'radius' => '100km'
            ],
            [
                'name'=> 'losangeles',
                'lat' => 34.052,
                'lon' => -118.243,
                'radius' => '1m'
            ],
            [
                'name'=> 'vancouver',
                'lat' => 49.25,
                'lon' => -123.1,
                'radius' => '100km'
            ]
        ];


        foreach($locations as $location){
            $params = [
                'index' => $this->index,
                'type' => $this->type,
                'body' => [
                    'name' => $location['name'],
                    'location' => [
                        'type' => 'circle',
                        'coordinates' => [$location['lon'], $location['lat']],
                        'radius' => $location['radius']
                    ]
                ]
            ];

            $response = \RES::index($params);
            $this->assertArrayHasKey('created',$response);
            $this->assertEquals(1, $response['created']);
        }
    }

    public function testQueryLocationInBoundary(){
        // use boundary of california
        $clientPoint = [-123.1, 49.25];
        $params = [
            'index' => $this->index,
            // 'type' => $this->type,
            'body' => [
                'query' => [
                    'geo_shape' => [
                        "location" => [
                            "shape" => [
                                'type' => 'circle',
                                'coordinates' => $clientPoint,
                                'radius'=>'10m'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        echo json_encode($params['body']);
        $response = \RES::search($params);

        $this->assertArrayHasKey('hits',$response);
        $this->assertEquals(1, $response['hits']['total']);
        // dd($response);

    }
}