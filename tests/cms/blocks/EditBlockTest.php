<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

use Rowboat\BlocksManagement\Models\Mongo\BlocksContentModelMongo;

class CreateNewBlockTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $blockId = '0';
    // public function 
    // 
    // public function testCheckRoute()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', 'api/block-manager/add-new');

    //     $request->assertEquals(405, $respone->getStatusCode());
    // }
    
    public function getContentBlockDefault()
    {
        $folder_id = 0;

        $result = BlocksContentModelMongo::first();

        if (!empty($result)) {
            $block = $result->cmsBlock()->first();
            $folder_id = (isset($block->folder_id)) ? $block->folder_id : 0;

            $this->blockId = $result->_id;
        }

        $_arrayValue = [
            'content' => "edit content block",
            'description' => "test edit content block",
            'folder_id' => $folder_id,
            'type' => "blade",
            'name' => "test block1" . time(),
        ];

        return $_arrayValue;
    }
    /**
     * [testCheckPermissionUserIsWrong description]
     * check create block with data is empty
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckPermissionUserIsWrong()
    {
        $_arrayValue = $this->getContentBlockDefault();

        $_arrayValue['_id'] = $this->blockId;

        $user = User::find(76);
        $request = $this->actingAs($user);

        $repone = $request->call('PUT', "api/block-manager/edit-block/" . $this->blockId, $_arrayValue);
        $request->assertEquals(404, $repone->getStatusCode());
    }

    /**
     * [testCheckPermissionUserIsTrue description]
     * check create block with data is empty
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckPermissionUserIsTrue()
    {
        $_arrayValue = $this->getContentBlockDefault();

        $_arrayValue['_id'] = $this->blockId;

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('PUT', "api/block-manager/edit-block/" . $this->blockId, $_arrayValue);

        $request->seeJson([
            'status' => 1,
        ]);
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
        $request->put("api/block-manager/edit-block/" . $this->blockId, $_arrayValue)
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
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        unset($input['name']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
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
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        $input['name'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
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
    public function testCheckDataMissFolder()
    {
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        unset($input['folder_id']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataWithFolderIsWrong description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithFolderIsWrong()
    {
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        $input['folder_id'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
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
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        unset($input['type']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataWithTypeIsWrong description]
     * check max length
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDataWithTypeIsWrong()
    {
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        $input['type'] = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
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
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        unset($input['description']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
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
        $input = $this->getContentBlockDefault();

        $input['_id'] = $this->blockId;

        unset($input['content']);

        $user = User::find(10);
        $request = $this->actingAs($user);
        $request->put("api/block-manager/edit-block/" . $this->blockId, $input)
            ->seeJson([
                'status' => 0,
            ]);
    }

    /**
     * [testCheckDataWithFoldeIdIsWrong description]
     *
     * [Kim Bang] [bang@httsolution.com]
     * @return [type] [description]
     */
    public function testCheckDataWithFoldeIdIsWrong()
    {
        $_arrayValue = [
            'content'=>"setsetst",
            'description'=>"setst",
            'folder_id'=>"56cd2278bffebc6c098b4568",
            'type'=>"blade",
            'name'=>"test block",
        ];

        $input['_id'] = $this->blockId;

        $user = User::find(10);

        $request = $this->actingAs($user);

        $request->put("api/block-manager/edit-block/" . $this->blockId, $_arrayValue)
                ->seeJson([
                    'status' => 0,
                    'errors' => ['Folder not exist!.'],
                ]);
    }

    /**
     * [testCheckDataWithBlockIdIsWrong description]
     *
     * [Kim Bang] [bang@httsolution.com]
     * @return [type] [description]
     */
    public function testCheckDataWithBlockIdIsWrong()
    {
        $_arrayValue = $this->getContentBlockDefault();

        $_arrayValue['_id'] = '56cd2278bffebc6c098b4568';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('PUT', "api/block-manager/edit-block/56cd2278bffebc6c098b4568", $_arrayValue);

        $request->seeJson(['status'=>0]);
    }

    /**
     * [testCheckDataWithFoldeIdIsTrue description]
     *
     * [Kim Bang] [bang@httsolution.com]
     * @return [type] [description]
     */
    public function testCheckDataWithFoldeIdIsTrue()
    {
        $_arrayValue = $this->getContentBlockDefault();

        $_arrayValue['_id'] = $this->blockId;

        $user = User::find(10);

        $request = $this->actingAs($user);

        $request->put("api/block-manager/edit-block/" . $this->blockId, $_arrayValue)
                ->seeJson([
                    'status' => 1,
                ]);
    }

    /**
     * [testCheckDataIsTrue description]
     *
     * [Kim Bang] [bang@httsolution.com]
     * @return [type] [description]
     */
    public function testCheckDataIsTrue()
    {
        $_arrayValue = $this->getContentBlockDefault();

        $_arrayValue['_id'] = $this->blockId;

        $user = User::find(10);

        $request = $this->actingAs($user);

        $request->put("api/block-manager/edit-block/" . $this->blockId, $_arrayValue)
                ->seeJson([
                    'status' => 1,
                ]);
    }
}
