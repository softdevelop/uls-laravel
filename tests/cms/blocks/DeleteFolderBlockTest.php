<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

use Rowboat\BlocksManagement\Models\Mongo\BlocksFolderModelMongo;

class DeleteFolderBlockTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_parentId = 0;

    protected $_id = '571d722c9a89200a936db201';

    /**
     * [testCheckRouteNotFound description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    // public function testCheckRouteNotFound()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $repone = $request->call('DELETE', 'api/block-manager/' . $this->_id);

    //     $request->assertEquals(404, $repone->getStatusCode());
    // }

    /**
     * [testCheckRouteWithMethodError description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    // public function testCheckRouteWithMethodError()
    // {
    //     $user = User::find(10);
    //     $request = $this->actingAs($user);

    //     $repone = $request->call('DELETE', 'api/block-manager');

    //     $request->assertEquals(405, $repone->getStatusCode());
    // }
    // 
    public function getIdFolderBlock()
    {
        $_id = 0;

        $result = BlocksFolderModelMongo::where('parent_id', '<>', '0')->first();

        if (!empty($result)) {
            $_id = $result->_id;
        }

        return $_id;
    }
    
    /**
     * [testCheckDeleteBlockNotExist description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDeleteBlockNotExist()
    {
        $_id = '569ced28d64791071f8b4568';

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('DELETE', 'api/block-manager/' . $_id);

        $request->assertEquals(200, $repone->getStatusCode());

        $request->seeJson([
            'status'=>0,
        ]);
    }

    /**
     * [testCheckDeleteBlockNotExist description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @return [type] [description]
     */
    public function testCheckDeleteBlockExisted()
    {
        $_id = $this->getIdFolderBlock();

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('DELETE', 'api/block-manager/' . $_id);

        $request->assertEquals(200, $repone->getStatusCode());

        $request->seeJson([
            'status'=>1,
        ]);
    }
}
