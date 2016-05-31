<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;

class CreateDirectoryBlockTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;


    protected $_parentId = 0;

    protected $_arrayValue;
    // public function 
    // 
    // public function testCheckRoute()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', 'api/block-manager/add-new');

    //     $request->assertEquals(405, $respone->getStatusCode());
    // }
    //
    
    /**
     * [getParentIdBlock description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @param  boolean $status [description]
     * @return [type]          [description]
     */
    public function getParentIdBlock($status = false)
    {
        $_idBlock = 0;
        $name = 'test create new block';
        $block = BlocksFolderModelMongo::where('parent_id', '0')->first();

        if (!empty($block)) {
            $this->_parentId = $block->_id;
            $_idBlock = $block->_id;
            if ($status) {
                $name = $block->name;
            }
        }

        $_arrayValue = [
            'name' => $name,
            'parent_id' => $_idBlock,
        ];

        return $_arrayValue;
    }


    /**
     * [testCheckPermissionUserAdmin description]
     *
     * @author [Kim Bang] <[bang@httsolution]>
     * @param  boolean $status [description]
     * @return [type]          [description]
     */
    public function testCheckPermissionUserAdmin($status = false)
    {
        $_arrayValue = $this->getParentIdBlock();
        $user = User::find(9);
        $request = $this->actingAs($user);
        $respone = $request->call('POST', "api/block-manager/create-folder", $_arrayValue);
        $request->assertEquals(404, $respone->getStatusCode());
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
        $request->post("api/block-manager/create-folder", $_arrayValue)
            ->seeJson([
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
        $_arrayValue = $this->getParentIdBlock();

        unset($_arrayValue['name']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/create-folder", $_arrayValue)
            ->seeJson([
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
        $_arrayValue = $this->getParentIdBlock();

        $_arrayValue['name'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/create-folder", $_arrayValue)
            ->seeJson([
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
        $_arrayValue = $this->getParentIdBlock(true);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/create-folder", $_arrayValue)
            ->seeJson([
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
        $_arrayValue = $this->getParentIdBlock();

        $_arrayValue['parent_id'] = "570a025b9a8920112613e070";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/create-folder", $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
    }


    /**
     * [testCheckDataWithParentFolderIsWrong description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithParentFolderIsWrong()
    {
        $_arrayValue = $this->getParentIdBlock();

        $_arrayValue['parent_id'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/create-folder", $_arrayValue)
            ->seeJson([
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
        $_arrayValue = $this->getParentIdBlock();

        $_arrayValue['name'] = 'create new Block '.time();

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/create-folder", $_arrayValue)
            ->seeJson([
                'status' => 1,
            ]);
    }
}
