<?php
class ItTicket extends TestCase{

    var $ticketId = null;
    /**
     * [testCreateTicketSuccess test create it ticket where success or not]
     * @author toan
     * @return [void]
     */
    public function testCreateTicketSuccess(){
        $response = $this->post('/api/ticket', 
            [
                'title' => 'Sally',
                'description'=>'aaa'
            ]
        )
        ->seeJson([
            'status' => 1,
        ]);
        $this->ticketId = $response->id;
    }

    public function testUserHasPermissionItAdminShouldSeeTheTicketInTheBucketOpen(){


        // find a user has permission is it_admin
        
        // sign in the user into the system
        
        // call api get tickets of the bucket open
         
        // assert $ticketId in the list tickets that is returned from the api
    }


    public function testUserHasPermissionItAdminShouldSeeTheTicketInTheBucketNew(){


        // find a user has permission is it_admin
        
        // sign in the user into the system
        
        // call api get tickets of the bucket open
         
        // assert $ticketId in the list tickets that is returned from the api
    }
    
    public function testUserHasPermissionItAdminShouldNotSeeTheTicketInTheBucketAssigned(){


        // find a user has permission is it_admin
        
        // sign in the user into the system
        
        // call api get tickets of the bucket open
         
        // assert $ticketId in the list tickets that is returned from the api
    }

    



}