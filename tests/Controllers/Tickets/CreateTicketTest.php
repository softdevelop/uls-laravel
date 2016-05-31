<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateTicketTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $this->assertTrue(true);
    // }

    /**
     * [testStoreTicket description]
     * @return [type] [description]
     */
    public function testStoreTicket()
    {
        $data = [   'type' => 'database_update',
                    'priority' => 'medium',
                    'title' => 'test',
                    'url' => 'http://uls.app/support/new',
                    'due_date' => '01-28-2016',
                    'description' => 'test description'
                ];


        $this->post('/api/support', $data);
    }

}
