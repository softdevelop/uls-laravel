<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;

class RequestNewBlockTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_parentId = 0;

    // public function 
    // 
    // public function testCheckRoute()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', 'api/block-manager');

    //     $request->assertEquals(200, $respone->getStatusCode());
    // }
    
    public function getDataBlock()
    {
        $folder_id = 0;

        $result = BlocksFolderModelMongo::first();

        if (!empty($result)) {
            $folder_id = $result->_id;
        }

        $_arrayValue = [
            'description' => '<div>aaa</div>',
            'due_date' => '2016-05-03T17:00:00.000Z',
            'folder_id' => $folder_id,
            'name' => 'aaaaaaaa',
            'type' => 'blade',
        ];

        return $_arrayValue;
    }

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

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissName description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissName()
    {
        $_arrayValue = $this->getDataBlock();

        unset($_arrayValue['name']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissFolder description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissFolder()
    {
        $_arrayValue = $this->getDataBlock();

        unset($_arrayValue['folder_id']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
        
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissType description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissType()
    {
        $_arrayValue = $this->getDataBlock();

        unset($_arrayValue['type']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $request->post('api/block-manager', $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissDueDate description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissDueDate()
    {
        $_arrayValue = $this->getDataBlock();

        unset($_arrayValue['due_date']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $request->post('api/block-manager', $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissDescription()
    {
        $_arrayValue = $this->getDataBlock();

        unset($_arrayValue['description']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $request->post('api/block-manager', $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
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
            $_arrayValue = $this->getDataBlock();

            $_arrayValue['name'] = bcrypt('request new' . time());
            $_arrayValue['due_date'] = $date;

            $user = User::find(10);

            $request = $this->actingAs($user);

            $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
        
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
        $_arrayValue = $this->getDataBlock();

        $_arrayValue['name'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithFolderIdIsNotExist()
    {
        $_arrayValue = $this->getDataBlock();

        $_arrayValue['name'] = bcrypt('request new' . time());

        $_arrayValue['folder_id'] = '570a025b9a8920112613e000';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithTypeIsNotExist()
    {
        $_arrayValue = $this->getDataBlock();

        $_arrayValue['name'] = bcrypt('request new' . time());

        $_arrayValue['type'] = 'test';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
    }

    /**
     * [testCheckDataWithFileIsNotExist description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithFileIsNotExist()
    {
        $_arrayValue = $this->getDataBlock();

        $_arrayValue['name'] = bcrypt('request new' . time());

        $_arrayValue['files_id'] = [425, 426, 427, 500000];

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);
    
        //$request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
    }

    /**
     * [testCheckDataIsPass description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataIsPass()
    {
        $_arrayValue = $this->getDataBlock();

        $_arrayValue['name'] = 'request new' . time();

        $_arrayValue['files_id'] = [425, 426, 427];

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/block-manager', $_arrayValue);

        $request->assertEquals(200, $repone->getStatusCode());

        $request->seeJson([
                'status' => 1,
            ]);
        
    }
}
