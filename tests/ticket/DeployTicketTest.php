<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TypeModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\PermissionModel;

class DeployTicketTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Session::start();

        $user = factory(UserModel::class)->create();
        Auth::login($user);
    }

    public function tearDown()
    {
        // UserModel::orderBy('id','desc')->first()->forceDelete();
        parent::tearDown();
    }

    public function getLastTicket()
    {
        $ticket = TicketModel::orderBy('id','desc')->first();
        return $ticket;
    }
    
    public function testDeployTicketTest()           
    {
        $user = \Auth::user();
        $ticket = TicketModel::where('status','approved')->first();
        
        if(!empty($ticket)) {
            $type = TypeModel::find($ticket->type_id);
            $sysAdmin = PermissionModel::where('slug','system_administrator')->first();
            $user->userPermissions()->attach([$sysAdmin->id]);

            $id = $ticket->id;

            $request = $this->post('/api/support/close/'.$ticket->id);
            $ticket = TicketModel::find($id);
            $this->assertEquals($ticket->status,'closed');

            $request->seeJson([
                'status' => 1,
            ]);            
        }
    }

}
