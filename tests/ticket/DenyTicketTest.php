<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TypeModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\PermissionModel;

class DenyTicketTest extends TestCase
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
    
    public function testDenyTicketTest()           
    {
        $user = \Auth::user();
        $ticket = TicketModel::where('status','reviewed')->first();
        

        if(!empty($ticket)) {
            $type = TypeModel::find($ticket->type_id);
            $perAdmin = $type->pemissions()->where('ticket_admin',1)->first();
            $user->userPermissions()->attach([$perAdmin->id]);

            $id = $ticket->id;

            $request = $this->post('/api/support/deny/'.$ticket->id);
            $ticket = TicketModel::find($id);
            $this->assertEquals($ticket->status,'assigned');

            $request->seeJson([
                'status' => true,
            ]);            
        }
    }

}
