<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TypeModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\PermissionModel;

class ReadyForReviewTest extends TestCase
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
    
    public function testReadyForReviewTicketTest()           
    {
        $user = \Auth::user();
        $ticket = TicketModel::where('status','assigned')->first();

        if(!empty($ticket)) {
            $assignee = UserModel::find($ticket->assign_id);
            \Auth::login($assignee);
            $id = $ticket->id;

            $request = $this->post('/api/support/readyforreviewed/'.$ticket->id);
            $ticket = TicketModel::find($id);
            $this->assertEquals($ticket->status,'reviewed');

            $request->seeJson([
                'status' => true,
            ]);            
        }
    }

}
