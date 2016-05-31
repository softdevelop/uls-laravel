<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TypeModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\PermissionModel;

class UpdateDueDateTicketTest extends TestCase
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
    
    public function testUpdateDueDateTicket()           
    {
        $dueDate = '2016-05-27';

        $user = \Auth::user();
        $ticket = $this->getLastTicket();
        $id = $ticket->id;

        $request = $this->post('/api/support/update-due-date/'.$ticket->id, 
                                [
                                    "due_date" => $dueDate,
                                    "check_due_date" => 1
                                ]
                            );
        $ticket = TicketModel::find($id);

        $this->assertEquals($dueDate. ' 17:00:00',$ticket->due_date);

        $request->seeJson([
            'status' => true,
        ]);

        return $ticket;
    }

}
