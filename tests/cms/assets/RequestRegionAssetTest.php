<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

class RequestRegionTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_parentId = 0;

    protected $_arrayValue = [
            '_id' => "571dce6895b0d625440009c1",
            'folder_id' => "56c499aad6479171778b4568",
            'alt_tag' => null,
            'meta' => '<div>ccx</div>',
            'width' =>"",
            'height' =>"",
            'description' => "<div>tests</div>",
            'due_date' => "2016-05-06T17:00:00.000Z",
            'file' => null,
            'folderName' => "css",
            'file_id' => "571dce6895b0d625440009c1",
            'language' => "en",
            'modal' => "request_region",
            'name' => "allmain",
            'percent_complete' => 0,
            'region' => null,
            'regions' => ['Andorra' => "aa"],
            'status' => "waiting-approve",
            'type' => "css",
        ];

    // public function 
    // 
    // public function testCheckRoute()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', 'api/block-manager/request-region');

    //     $request->assertEquals(200, $respone->getStatusCode());
    // }
    

    /**
     * [testCheckDataIsEmpty description]
     * check create block with data is empty
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataIsEmpty()
    {
        $_arrayValue = [];
        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
        
        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissName description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissName()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['name']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
        
        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissFolder description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissFolder()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['folder_id']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
        
        // $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }
    /**
     * [testCheckDataMissDueDate description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissDueDate()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['due_date']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $request->post('api/asset-manager/request-region', $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissDescription()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['description']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $request->post('api/asset-manager/request-region', $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissIdAndBaseId description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissIdAndBaseId()
    {
        $_arrayValue = $this->_arrayValue;

        unset($_arrayValue['_id']);
        unset($_arrayValue['file_id']);
        $user = User::find(10);
        $request = $this->actingAs($user);

        $request->post('api/asset-manager/request-region', $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
    }
    // 
    /**
     * [testCheckExistLanguage description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckExistLanguage()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['language'] = 'enhn';

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckExistRegion description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckExistRegion()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['regions'] = ['aa'=>'aa', 'bb'=>'bb', 'cc'=>'cc'];

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
    }
 
    /**
     * [testCheckDataWithDueDateNotMatchFormatDate description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithDueDateNotMatchFormatDate()
    {
        $_arrayValueDate = ['2-30-2016 11:12:12', '30-2-2016 11:12:12', '2016-30-2 11:12:12', '2016-2-30 11:12:12',
            '2-2016-29 11:12:12', '29-2016-2 11:12:12', '2-29-2016 25:12:12', '2-29-2016 22:61:12', '2-29-2016 22:12:120', 'abc', 'August 2016, 10'];

        foreach ($_arrayValueDate as $key => $date) {
            $_arrayValue = $this->_arrayValue;

            $_arrayValue['name'] = bcrypt('request new' . time());
            $_arrayValue['regions'] = ['us' => 'us'];
            $_arrayValue['due_date'] = $date;

            $user = User::find(10);

            $request = $this->actingAs($user);

            $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
        
            $request->assertEquals(422, $repone->getStatusCode());

            $request->seeJson([
                    'status' => 0,
                ]);
        }        
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithNameIsInvalidMaxLength()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';

        $_arrayValue['regions'] = ['us' => 'us'];

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
    
        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);        
    }

    /**
     * [testCheckDataMissDescription description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithFolderIdIsNotExist()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = bcrypt('request new' . time());

        $_arrayValue['folder_id'] = 'sdsdsd';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
    
        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
    }

    /**
     * [testCheckDataWithFileIsNotExist description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithFileIsNotExist()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = bcrypt('request new' . time());
        
        $_arrayValue['regions'] = ['us'=>'us'];

        $_arrayValue['files_id'] = [425, 426, 427, 500000];

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
    
        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status' => 0,
            ]);
        
    }

    /**
     * [testCheckDataIsPass description]
     *
     * @author [van linh] <[vanlinh@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataIsPass()
    {
        $_arrayValue = $this->_arrayValue;

        $_arrayValue['name'] = 'request new' . time();

        $_arrayValue['regions'] = ['aa'=>'aa'];

        $_arrayValue['files_id'] = [23, 21, 22];
        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('POST', 'api/asset-manager/request-region', $_arrayValue);
        $request->assertEquals(200, $repone->getStatusCode());

        $request->seeJson([
                'status' => 1,
            ]);
        
    }
}
