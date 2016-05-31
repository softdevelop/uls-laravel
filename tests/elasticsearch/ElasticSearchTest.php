<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

// reference link https://github.com/elastic/elasticsearch-php
class ElasticSearchTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    // public function testCleanData(){
    //     $deleteParams = [
    //         'index' => 'pages'
    //     ];
    //     $response = \RES::indices()->delete($deleteParams);
    //     $this->assertArrayHasKey('acknowledged',$response);
    //     $this->assertEquals(1, $response['acknowledged']);
    // }
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testElasticSearchWork()
    {
        $response = \RES::indices()->stats();
        $this->assertArrayHasKey('indices',$response);
    }

    public function testCreateIndex(){
        $params = [
            'index' => 'pages',
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

    public function testDeleteIndex(){
        $deleteParams = [
            'index' => 'pages'
        ];
        $response = \RES::indices()->delete($deleteParams);
        $this->assertArrayHasKey('acknowledged',$response);
        $this->assertEquals(1, $response['acknowledged']);
    }


    public function testCreateDocument(){
        $params = [
            'index' => 'pages',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => ['testField' => 'abc']
        ];

        $response = \RES::index($params);
        $this->assertArrayHasKey('created',$response);
        $this->assertEquals(1, $response['created']);
    }

    public function testGetDocument(){
        $params = [
            'index' => 'pages',
            'type' => 'my_type',
            'id' => 'my_id'
        ];

        $response = \RES::get($params);
        $this->assertArrayHasKey('found',$response);
        $this->assertEquals(1, $response['found']);
    }

    public function testRemoveDocument(){
        $params = [
            'index' => 'pages',
            'type' => 'my_type',
            'id' => 'my_id'
        ];

        $response = \RES::delete($params);
        $this->assertArrayHasKey('found',$response);
        $this->assertEquals(1, $response['found']);
    }
}
