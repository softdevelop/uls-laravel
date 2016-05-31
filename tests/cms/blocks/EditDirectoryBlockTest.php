<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;

class EditDirectoryBlockTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_id = '0';

    // public function 

    /**
     * [testCheckRouteWithErrorCode405 description]
     * check route not found (error code 404)
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    // public function testCheckRouteWithErrorCode404()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', "api/block-manager/edit-name-folder");

    //     $request->assertEquals(404, $respone->getStatusCode());
    // }

    /**
     * [testCheckRouteWithErrorCode405 description]
     * check route with method is wrong (error code 405)
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    // public function testCheckRouteWithErrorCode405()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', "api/block-manager/edit-name-folder");

    //     $request->assertEquals(405, $respone->getStatusCode());
    // }

    // public function testCheckRoutePass()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', "api/block-manager/edit-name-folder/" . $this->_id);


    //     $request->assertArrayHasKey('status', json_decode($respone->getContent(), true));
    // }
    

    public function getContentDirectory()
    {
        $parent_id = 0;

        $result = BlocksFolderModelMongo::where('parent_id', '<>', '0')->first();

        if (!empty($result)) {
            $parent_id = $result->parent_id;
            $this->_id = $result->_id;
        }

        $_arrayValue = [
            'name' => "create directory",
            'parent_id'=>$parent_id,
            '_id' => $this->_id,
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

        $respone = $request->call('POST', "api/block-manager/edit-name-folder/" . $this->_id, $_arrayValue);
        
        //$request->assertEquals(422, $respone->getStatusCode());

        $request->seeJson([
                    'status' => 0,
                ]);
    }


    /**
     * [testCheckDataMissName description]
     * check create block with data is empty
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissName()
    {
        $_arrayValue = $this->getContentDirectory();

        unset($_arrayValue['name']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $respone = $request->call('POST', "api/block-manager/edit-name-folder/" . $this->_id, $_arrayValue);
        
        //$request->assertEquals(422, $respone->getStatusCode());
        
        $request->seeJson([
                    'status' => 0,
                ]);
    }


    /**
     * [testCheckDataWithNameIsWrong description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithNameIsWrong()
    {
        $_arrayValue = $this->getContentDirectory();

        $_arrayValue['name'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);

        $respone = $request->call('POST', "api/block-manager/edit-name-folder/" . $this->_id, $_arrayValue);
        
        //$request->assertEquals(422, $respone->getStatusCode());
        
        $request->seeJson([
                    'status' => 0,
                ]);
    }
    
    /**
     * [testCheckDataWithNameExist description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithNameExist()
    {
        $_arrayValue = $this->getContentDirectory();

        $_arrayValue['name'] = "Blocks";

        $user = User::find(10);
        $request = $this->actingAs($user);

        $respone = $request->call('POST', "api/block-manager/edit-name-folder/" . $this->_id, $_arrayValue);
        
        //$request->assertEquals(422, $respone->getStatusCode());
        
        $request->seeJson([
                    'status' => 0,
                ]);
    }

    /**
     * [testCheckDataWithParentIdIsNotExist description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithParentIdIsNotExist()
    {
        $_arrayValue = $this->getContentDirectory();

        $_arrayValue['parent_id'] = "570a025b9a8920112613e070";

        $_arrayValue['name'] = 'create new Block' . time();

        $user = User::find(10);
        $request = $this->actingAs($user);

        $respone = $request->call('POST', "api/block-manager/edit-name-folder/" . $this->_id, $_arrayValue);
        
        //$request->assertEquals(422, $respone->getStatusCode());
        
        $request->seeJson([
                    'status' => 0,
                ]);
    }


    /**
     * [testCheckDataWithDirectoryNotExist description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithDirectoryNotExist()
    {
        $_arrayValue = $this->getContentDirectory();

        $_arrayValue['_id'] = "570a025b94a8920112613e070";

        $_arrayValue['name'] = 'create new Block' . time();

        $user = User::find(10);
        $request = $this->actingAs($user);

        $respone = $request->call('POST', "api/block-manager/edit-name-folder/" . $_arrayValue['_id'], $_arrayValue);
        
        // //$request->assertEquals(422, $respone->getStatusCode());
        
        $request->seeJson([
                    'status' => 0,
                ]);
    }

    /**
     * [testCheckDataTrue description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataTrue()
    {
        $_arrayValue = $this->getContentDirectory();

        $_arrayValue['name'] = 'edit directory name '.time();

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/edit-name-folder/" . $this->_id, $_arrayValue)
            ->seeJson([
                'status' => 1,
            ]);
    }
}
