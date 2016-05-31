<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\Users\Models\UserModel;
use Rowboat\Ticket\Models\TypeModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\Users\Models\PermissionModel;

class CreateNewTicketTest extends TestCase
{

//     protected $userId = 41;
//     protected $ticketId = 0;
//     protected $listTicketIds = [];
    protected $ticketType = 'legacy_create_new_page';
    
//     use DatabaseTransactions;

    public static function setUpBeforeClass()
    {

    }
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

    public static function tearDownAfterClass()
    {
        // DB::rollback();

        // parent::tearDownAfterClass();
    }

    public function getLastTicket()
    {
        $ticket = TicketModel::orderBy('id','desc')->first();
        return $ticket;
    }

    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

    /**
     * Test Create New Ticket with wrong data
     *
     * @author Quang <quang@httsolution.com>
     *
     * @return void
     */
    // public function testCreateNewTicketWithWrongData()
    // {
    //     $data = [
    //                 // 'title' => 'Sally',
    //                 'type' => $this->ticketType,
    //                 'priority' => 'medium',
    //                 'due_date' => '04-08-2016',
    //                 'description' => 'quang'
    //             ];

    //     $request = $this->post('/api/support',$data);
    //     $return = json_decode($request->response->getContent(),true);
    //     var_dump($return);
    //     $request->seeJson([
    //         'status' => 0,
    //     ]);
    // }
    
    
    /**
     * Test Create New Ticket with right data
     *
     * @author Quang <quang@httsolution.com>
     *
     * @return void
     */
    public function testCreateNewTicketWithRightData()
    {
        $request = $this->post('/api/support', 
                                [
                                    'title' => 'Sally',
                                    'type' => $this->ticketType,
                                    'priority' => 'medium',
                                    'due_date' => '09-05-2016',
                                    'description' => 'quang'
                                ]
                            );


        $return = json_decode($request->response->getContent(),true);

        $request->seeJson([
            'status' => 1,
        ]);

        $lastTicket = $this->getLastTicket();
        $this->assertEquals($lastTicket['id'], $return['item']['id']);

        return $return['item'];
    }

    public function checkUserCanSeeTicketInBucket($user_id,$ticket, $state, $canSee = true)
    {
        $user = UserModel::find($user_id);
        Auth::login($user);

        $request = $this->call('GET','/support/state/'.$state);
        $this->assertEquals(200,$request->getStatusCode());

        $fetchId = array_fetch($request->original['items']->toArray(),'id');

        $this->assertEquals($canSee,in_array($ticket['id'], $fetchId));
    }

    /**
     * @depends testCreateNewTicketWithRightData
     * 
     * [testCheckUserHasPermissonShouldSeeTicketInBucketNew description]
     * @param  [type] $ticket [description]
     * @return [type]         [description]
     */
    public function testCheckUserHasPermissonShouldSeeTicketInBucketNew($ticket)
    {
        $user = \Auth::user();
        
        //check user do not have permission then can not see ticket
        $this->checkUserCanSeeTicketInBucket($user->id,$ticket,'new',false);

        //orginator
        $this->checkUserCanSeeTicketInBucket($ticket['user_id'],$ticket,'new');

        //ticket admin
        $perAdminSlug = $this->ticketType . '_ticket_admin';
        $perAdminID = PermissionModel::where('slug', $perAdminSlug)->first();
        $user->userPermissions()->attach([$perAdminID->id]);
        $this->checkUserCanSeeTicketInBucket($user->id, $ticket,'new');
    }
    
}
