<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Rowboat\Users\Models\UserModel as User;

class DemoTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    protected $_parentId = 0;

    protected $_arrayValue = [
            'name' => "create directory",
            'parent_id'=>"570a025b9a8920112613e072",
        ];
    

    public function testGetContentView()
    {
        $user = User::find(10);
        $request = $this->actingAs($user);

        $repone = $request->call('GET', )
    }
}
