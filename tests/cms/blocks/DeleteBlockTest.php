<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

use Rowboat\BlocksManagement\Models\Mongo\BlocksModelMongo;

class DeleteBlockTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_parentId = 0;

    protected $_id = '571d6f6a9a892008fd6ba0e3';

    protected $_arrayValue = [
            'name' => "create directory",
            'parent_id'=>"570a025b9a8920112613e072",
        ];

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
    public function getIdBlock()
    {
        $_id = 0;

        $result = BlocksModelMongo::first();

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
        $_id = '0';

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
        $_id = $this->getIdBlock();

        $user = User::find(10);

        $request = $this->actingAs($user);

        $repone = $request->call('DELETE', 'api/block-manager/' . $_id);
        
        $request->assertEquals(200, $repone->getStatusCode());

        $request->seeJson([
            'status'=>1,
        ]);
    }
}
