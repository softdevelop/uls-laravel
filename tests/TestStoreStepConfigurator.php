<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\DatabaseManagement\Models\Mongo\ConfiguratorMongo;
use Rowboat\Users\Models\UserModel;

class TestStoreStepConfigurator extends TestCase
{

	protected $userId = 6;
    protected $configuratorId = 0;


	public function setUp()
    {
        parent::setUp();
        Session::start();

        $user = UserModel::find(6);
        \Auth::login($user);
    }

    public function tearDown()
    { 
        
        // dd($this->configuratorId);
       // \DB::connection('mongodb')->table('configurator.userconfig')->where('_id', $this->configuratorId)->delete();
       parent::tearDown();

    }


    public function testStoreConfiguratorStep1()
    {
        $input1 = ['materials' => [
            ['id' => 1, 'name' => 'test'],
            ['id' => 2, 'name' => 'test1']
        ]];

        $input2 = [
            'answerQuestions' => [
                'question_first' => 'dimensional',
                'question_second'=> 'continuous',
                'question_third' => 'productivity'
            ]
        ];

        $input3 = [
            'step' => 1,
            'platform_id' => 1,
            'selectedAccessories' => [
                ['id' => 1, 'name' => 'test1'],
                ['id' => 2, 'name' => 'test2']
            ]
        ];

        $input = array_merge($input1, $input2, $input3);

        $response = $this->call('POST', '/api/configurator', $input);
        $this->assertEquals(200, $response->status());

    }

    public function testStoreConfiguratorStep2()
    {
        $input1 = ['materials' => [
            ['id' => 1, 'name' => 'test'],
            ['id' => 2, 'name' => 'test1']
        ]];

        $input2 = [
            'answerQuestions' => [
                'question_first' => 'dimensional',
                'question_second'=> 'continuous',
                'question_third' => 'productivity'
            ]
        ];

        $input3 = [
            'step' => 2,
            'platform_id' => 1,
            'selectedAccessories' => [
                ['id' => 1, 'name' => 'test1'],
                ['id' => 2, 'name' => 'test2']
            ]
        ];

        $input = array_merge($input1, $input2, $input3);

        $response = $this->call('POST', '/api/configurator', $input);
        $this->assertEquals(200, $response->status());

    }

    public function testStoreConfiguratorStep3()
    {
        $input1 = ['materials' => [
            ['id' => 1, 'name' => 'test'],
            ['id' => 2, 'name' => 'test1']
        ]];

        $input2 = [
            'answerQuestions' => [
                'question_first' => 'dimensional',
                'question_second'=> 'continuous',
                'question_third' => 'productivity'
            ]
        ];

        $input3 = [
            'step' => 3,
            'platform_id' => 1,
            'selectedAccessories' => [
                ['id' => 1, 'name' => 'test1'],
                ['id' => 2, 'name' => 'test2']
            ]
        ];

        $input = array_merge($input1, $input2, $input3);

        $response = $this->call('POST', '/api/configurator', $input);
        $this->assertEquals(200, $response->status());

    }
    // /**
    //  * A basic test example.
    //  *
    //  * @return void
    //  */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

    public function testStoreStep1()
    {

    	$input = ['materials' => [
    		['id' => 1, 'name' => 'test'],
    		['id' => 2, 'name' => 'test1']
    	]];

    	$configuratorMongo = new ConfiguratorMongo();
        $dataStep1 = $configuratorMongo->storeStep1($input);

        $this->configuratorId = $dataStep1->_id;

        $item = $dataStep1;
        // dd($item;die;

       	$coundMaterials = $item->materials;

        $this->assertEquals(count($input['materials']), count($coundMaterials));
    }

    public function testStoreStep1ExitId()
    {
    	$this->testStoreStep1();

    	$input = ['materials' => [
    		['id' => 1, 'name' => 'test'],
    		['id' => 2, 'name' => 'test1']
    	]];

    	$configuratorMongo = ConfiguratorMongo::find($this->configuratorId);
        $dataStep1 = $configuratorMongo->storeStep1($input);

        $this->configuratorId = $dataStep1->_id;

        $item = ConfiguratorMongo::find($this->configuratorId)->first();
        // dd($item;die;

       	$coundMaterials = $item->materials;

        $this->assertEquals(count($input['materials']), count($coundMaterials));
    }

    public function testStoreStep2()
    {	
    	$input = [
    		'answerQuestions' => [
    			'question_first' => 'dimensional',
    			'question_second'=> 'continuous',
    			'question_third' => 'productivity'
    		]
    	];

    	$configuratorMongo = new ConfiguratorMongo();
        $dataStep2 = $configuratorMongo->storeStep2($input);

        $this->configuratorId = $dataStep2->_id;

        $item = $dataStep2;
        
       	$coundMaterials = $item->answerQuestions;

        $this->assertEquals(count($input['answerQuestions']), count($coundMaterials));
    }

    public function testStoreStep2ExitId()
    {	
    	$this->testStoreStep2();
    	$input = [
    		'answerQuestions' => [
    			'question_first' => 'dimensional',
    			'question_second'=> 'continuous',
    			'question_third' => 'productivity'
    		]
    	];

    	$configuratorMongo = ConfiguratorMongo::find($this->configuratorId);
        $dataStep2 = $configuratorMongo->storeStep2($input);

        $this->configuratorId = $dataStep2->_id;

        $item = $dataStep2;

        // dd($item->answerQuestions);
       	$coundMaterials = $item->answerQuestions;

        $this->assertEquals(count($input['answerQuestions']), count($coundMaterials));
    }

    public function testStoreStep3()
    {
 
    	$input = [
    		'platform_id' => 1,
    		'selectedAccessories' => [
    			['id' => 1, 'name' => 'test1'],
    			['id' => 2, 'name' => 'test2']
    		]
    	];

    	$configuratorMongo = new ConfiguratorMongo();
        $dataStep3 = $configuratorMongo->storeStep3($input);
        $this->configuratorId = $dataStep3->_id;
        $item = $dataStep3;

        // dd($item->answerQuestions);
       	$coundMaterials = $item->selected_accesoryIds;

        $this->assertEquals(count($input['selectedAccessories']), count($coundMaterials));
    }

    public function testStoreStep3ExitId()
    {
 		$this->testStoreStep3();
    	$input = [
    		'platform_id' => 1,
    		'selectedAccessories' => [
    			['id' => 1, 'name' => 'test1'],
    			['id' => 2, 'name' => 'test2']
    		]
    	];

    	$configuratorMongo = ConfiguratorMongo::find($this->configuratorId);
        $dataStep3 = $configuratorMongo->storeStep3($input);
        $this->configuratorId = $dataStep3->_id;
        $item = $dataStep3;

        // dd($item->answerQuestions);
       	$coundMaterials = $item->selected_accesoryIds;

        $this->assertEquals(count($input['selectedAccessories']), count($coundMaterials));
    }


}
