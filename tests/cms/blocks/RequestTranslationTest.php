<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\UserModel as User;

class RequestTranslationTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_parentId = 0;

    protected $_arrayValue = [
            '_id' => "571d6f699a892008fd6ba0e1",
            'ancestor_ids' => ["571cdfa59a892008a953d2e1", "570a025b9a8920112613e072", "0"],
            'created_at' => "2016-04-24 15:00:53",
            'description' => "<div>dsfdsf</div>",
            'due_date' => "2016-05-06T17:00:00.000Z",
            'folderName' => "Blocks",
            'folder_id' => "570a025b9a8920112613e072",
            'languages' => ['Chinese' => "zh"],
            'modal' => "request_translation",
            'name' => "test123123123",
            'type' => "blade",
            'typeName' => "BLADE",
        ];

    // public function 
    // 
    // public function testCheckRoute()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', 'api/block-manager/request-translation');

    //     $request->assertEquals(200, $respone->getStatusCode());
    // }
    

    /**
     * [testCheckDataIsEmpty description]
     * check create block with data is empty
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataIsEmpty()
    {
        $_arrayValue = [];
        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);

        ////print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissName description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissName()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['name']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissFolder description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissFolder()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['folder_id']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissType description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissType()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['type']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);

        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissDueDate description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissDueDate()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['due_date']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissDescription()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['description']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissIdAndBaseId description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissId()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['_id']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissIdAndBaseId description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissLanguge()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['languages']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        // $request->dump();
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
        //print_r($repone->getContent());
    }
    // 
    /**
     * [testCheckNotExistLanguage description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckNotExistLanguage()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['language'] = ['ddd' => 'enhn'];

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);

        //print_r($repone->getContent());
    }
    
    /**
     * [testCheckExistBlockWithLanguage description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckExistBlockWithLanguage()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['languages'] = ['dd' => 'en'];

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        //print_r($repone->getContent());
    }

    
    /**
     * [testCheckDataWithDueDateNotMatchFormatDate description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithDueDateNotMatchFormatDate()
    {
        $_arrayValueDate = ['2-30-2016 11:12:12', '30-2-2016 11:12:12', '2016-30-2 11:12:12', '2016-2-30 11:12:12',
            '2-2016-29 11:12:12', '29-2016-2 11:12:12', '2-29-2016 25:12:12', '2-29-2016 22:61:12', '2-29-2016 22:12:120', 'abc', 'August 2016, 10'];

        foreach ($_arrayValueDate as $key => $date) {
            $_arrayValue = $this->_arrayValue;

            $_arrayValue['name'] = bcrypt('request new' . time());
            $_arrayValue['due_date'] = $date;

            $user = User::find(10);

            $request = $this->actingAs($user);

            $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
        
            //$request->assertEquals(422, $repone->getStatusCode());

            $request->seeJson([
                    'status' => 0,
                ]);
        }
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithNameIsInvalidMaxLength()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);

        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithFolderIdIsNotExist()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = bcrypt('request new' . time());

        $_arrayValue['folder_id'] = '570a025b9a8920112613e000';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);

        //print_r($repone->getContent());        
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithTypeIsNotExist()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = bcrypt('request new' . time());

        $_arrayValue['type'] = 'test';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);

        //print_r($repone->getContent());
        
    }

    /**
     * [testCheckDataWithFileIsNotExist description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithFileIsNotExist()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = bcrypt('request new' . time());

        $_arrayValue['files_id'] = [425, 426, 427, 500000];

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);

        //print_r($repone->getContent());
    }

    /**
     * [testCheckDataIsPass description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataIsPass()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = 'request new' . time();

        $_arrayValue['files_id'] = [425, 426, 427];

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager/request-translation', $_arrayValue);

        $request->assertEquals(200, $repone->getStatusCode());

        $request->seeJson([
                'status' => 1,
            ]);

        if($repone->getContent()) {
            $content = json_decode($repone->getContent(), true);
            foreach ($content as $key1 => $value) {
                foreach ($value as $key2 => $item) {
                    if (isset($item['ticket_id']) && isset($item['_id'])) {
                        return ['_id' => $item['_id'], 'ticket_id' => $item['ticket_id']];
                    }
                }
            }
        } else {
            return false;
        }

        //print_r($repone->getContent());
        
    }

    /**
     * @depends testCheckDataIsPass
     * 
     * [testTicket description]
     * @return [type] [description]
     */
    public function testTicket($arrayValue)
    {
        $tickets = TicketModel::where('id', $arrayValue['ticket_id'])->first();

        $this->assertNotEquals($tickets, []);
    }
}
