<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\Mongo\HelpEditorModelMongo;

use Rowboat\Users\Models\UserModel as User;

class CreateNewTopic extends TestCase
{

    public function getData()
    {
        $result = HelpEditorModelMongo::where('parent_id', '0')->first();
        if (empty($result)) {
            return [];
        } else {
            return [
                'title' => 'create topic ' . time(),
                'parent_id' => $result->_id,
            ];
        }
    }

    public function getDataWithParentIdIsNotZero()
    {
        $result = HelpEditorModelMongo::where('parent_id', '!=', '0')->first();
        if (empty($result)) {
            return [];
        } else {
            return [
                'title' => $result->title,
                'parent_id' => $result->parent_id,
            ];
        }
    }

    /**
     * [checkRoute description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    // public function testCheckRoute()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $respone = $request->call('POST', 'api/help-editor/create-new-topic');

    //     $request->assertEquals(405, $respone->getStatusCode());
    // }
    
    /**
     * [testCheckAddTopicWitdDataEmpty description]
     * check create topic with data is empty
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckAddTopicWitdDataEmpty()
    {
        $_arrayValue = [];

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', "api/help-editor/create-new-topic", $_arrayValue);

        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status'=>0,
            ]);
    }

    /**
     * [testCheckAddTopicWithDataMissTitle description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckAddTopicWithDataMissTitle()
    {
        $_arrayValue = $this->getData();

        unset($_arrayValue['title']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', "api/help-editor/create-new-topic", $_arrayValue);

        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status'=>0,
            ]);
    }

    /**
     * [testCheckAddTopicWithDataMissParentId description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckAddTopicWithDataMissParentId()
    {
        $_arrayValue = $this->getData();

        unset($_arrayValue['parent_id']);

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', "api/help-editor/create-new-topic", $_arrayValue);

        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status'=>0,
            ]);
    }

    /**
     * [testCheckAddTopicWithParentIdNotExist description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckAddTopicWithParentIdNotExist()
    {
        $_arrayValue = $this->getData();

        $_arrayValue['parent_id'] = '123';

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', "api/help-editor/create-new-topic", $_arrayValue);

        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status'=>0,
            ]);
    }

    /**
     * [testCheckAddTopicWithDataPass description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckAddTopicWithDataPass()
    {
        $_arrayValue = $this->getData();

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', "api/help-editor/create-new-topic", $_arrayValue);

        $request->assertEquals(200, $repone->getStatusCode());

        $request->seeJson([
                'status'=>1,
            ]);
    }

    /**
     * [testCheckAddTopicWithDataPass description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckAddTopicWithExistTitle()
    {
        $_arrayValue = $this->getDataWithParentIdIsNotZero();

        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('POST', "api/help-editor/create-new-topic", $_arrayValue);

        $request->assertEquals(422, $repone->getStatusCode());

        $request->seeJson([
                'status'=>0,
            ]);
    }

}
