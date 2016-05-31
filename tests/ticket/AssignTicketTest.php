<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TypeModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\PermissionModel;

class AssignTicketTest extends TestCase
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

    // public function testExample()
    // {
    //     $typeID = 15;
    //     $type = TypeModel::find(15);
    //     dd($type->pemissions()->where('ticket_admin',1)->get()->toArray());

    //     $this->assertTrue(true);
    // }
    
    public function checkUserCanSeeTicketInBucket($user_id,$ticket, $state, $canSee = true)
    {
        $user = UserModel::find($user_id);
        \Auth::login($user);

        $request = $this->call('GET','/support/state/'.$state);

        $this->assertEquals(200,$request->getStatusCode());

        $fetchId = array_fetch($request->original['items']->toArray(),'id');

        $this->assertEquals($canSee,in_array($ticket['id'], $fetchId));
    }

    public function testAssignTicket()           
    {
        $user = \Auth::user();
        $ticket = $this->getLastTicket();

        $request = $this->post('/api/support/add-assign/'.$ticket->id, 
                                [
                                    'user_id' => $user->id,
                                ]
                            );
        $request->seeJson([
            'status' => true,
        ]);
        $ticket->assign_id = $user->id;
        return $ticket;
    }

    /**
     * @depends testAssignTicket
     */
    public function testCheckUserHasPermissonShouldSeeTicketInBucket($ticket)
    {
        $user = \Auth::user();
        $type = TypeModel::find($ticket->type_id);
        $perAdmin = $type->pemissions()->where('ticket_admin',1)->first();
        $perAssign = $type->pemissions()->where('ticket_admin',0)->first();

        //check assignee should see ticket in bucket
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'all_open',true);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'assigned-to-me',true);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'opened-by-me',false);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'following',false);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'new',false);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'assigned',true);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'reviewed',false);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'approved',false);
        $this->checkUserCanSeeTicketInBucket($ticket->assign_id,$ticket,'deployed',false);

        //attach permission admin to user
        $user->userPermissions()->attach([$perAdmin->id]);
        //check ticket admin
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'all_open',true);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'assigned-to-me',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'opened-by-me',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'following',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'new',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'assigned',true);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'reviewed',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'approved',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'deployed',false);

        //detach permission ticket admin
        $user->userPermissions()->detach([$perAdmin->id]);
        //attach ticket assign
        $user->userPermissions()->attach([$perAssign->id]);
        //check user have permission ticket assign
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'all_open',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'assigned-to-me',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'opened-by-me',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'following',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'new',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'assigned',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'reviewed',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'approved',false);
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'deployed',false);

        //check originator
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'all_open',true);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'assigned-to-me',false);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'opened-by-me',true);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'following',false);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'new',false);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'assigned',true);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'reviewed',false);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'approved',false);
        $this->checkUserCanSeeTicketInBucket($ticket->user_id,$ticket,'deployed',false);
    }

}
