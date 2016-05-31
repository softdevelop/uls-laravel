<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;

class CreateNewBlockTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_arrayValue = [
            'content'=>"setsetst",
            'description'=>"setst",
            'folder'=>"570a025b9a8920112613e072",
            'type'=>"blade",
            'name'=>"test block",
        ];
    // public function 
    // 
    // public function testCheckRoute()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', 'api/block-manager/add-new');

    //     $request->assertEquals(405, $respone->getStatusCode());
    // }

    public function getContentDefault()
    {
        $folder_id = 0;

        $result = BlocksFolderModelMongo::where('parent_id', '0')->first();

        if (!empty($result)) {
            $folder_id = $result->_id;
        }

        $_arrayValue = [
            'content' => "setsetst",
            'description' => "setst",
            'folder' => $folder_id,
            'type' => "blade",
            'name' => "test block" . time(),
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
    // public function testCheckPermissionUserAdmin($status = false)
    // {
    //     $_arrayValue = $this->getParentIdBlock();
    //     $user = User::find(9);
    //     $request = $this->actingAs($user);
    //     $respone = $request->call('POST', "api/block-manager/add-new", $_arrayValue);
    //     $request->assertEquals(404, $respone->getStatusCode());
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
        $request->post("api/block-manager/add-new", $_arrayValue)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissFolder description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissName()
    {
        $input = $this->getContentDefault();

        unset($input['name']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/add-new", $input)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataWithNameIsWrong description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithNameIsWrong()
    {
        $input = $this->getContentDefault();

        $input['name'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/add-new", $input)
            ->seeJson([
                'status' => 0,
            ]);
    }


    /**
     * [testCheckDataIsEmpty description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissFolder()
    {
        $input = $this->getContentDefault();

        unset($input['folder']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/add-new", $input)
            ->seeJson([
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
        $input = $this->getContentDefault();

        unset($input['type']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/add-new", $input)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataWithTypeIsWrong description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithTypeIsWrong()
    {
        $input = $this->getContentDefault();

        $input['type'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/add-new", $input)
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
        $input = $this->getContentDefault();

        unset($input['description']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/add-new", $input)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataMissContent description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataMissContent()
    {
        $input = $this->getContentDefault();

        unset($input['content']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->post("api/block-manager/add-new", $input)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataWithFoldeIdIsWrong description]
     * @return [type] [description]
     */
    public function testCheckDataWithFoldeIdIsWrong()
    {
        $_arrayValue = [
            'content'=>"setsetst",
            'description'=>"setst",
            'folder'=>"56cd2278bffebc6c098b4568",
            'type'=>"blade",
            'name'=>"test block",
        ];

        $user = User::find(10);

        $request = $this->actingAs($user);

        $request->post("api/block-manager/add-new", $_arrayValue)
                ->seeJson([
                    'status' => 0
                ]);
    }

    /**
     * [testCheckDataIsTrue description]
     * @return [type] [description]
     */
    public function testCheckDataIsTrue()
    {
        $_arrayValue = $this->getContentDefault();

        $user = User::find(10);

        $request = $this->actingAs($user);

        $request->post("api/block-manager/add-new", $_arrayValue)->dump()
                ->seeJson([
                    'status' => 1,
                ]);
    }
}
