<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Mongo\DashboardModelMongo ;
use App\Models\UserModel;
class EditDashboardTest extends TestCase
{
    /**
     * test Edit Sort Element
     *
     * @author van linh <vanlinh@httsolution.com>
     * @return [type] [description]
     */
    public function testEditSortElement()
    {
        $user = UserModel::find(6);
        $data = [
            [
                'user_id' => $user->id,
                'sort_order' => 0,
                'collapse' => true,
                'file_name' => 'page-overview'
            ],
            [
                'user_id' => $user->id,
                'sort_order' => 1,
                'collapse' => true,
                'file_name' => 'traffic-overview'
            ],
            [
                'user_id' => $user->id,
                'sort_order' => 2,
                'collapse' => true,
                'file_name' => 'ticket-overview'
            ],
            [
                'user_id' => $user->id,
                'sort_order' => 3,
                'collapse' => true,
                'file_name' => 'task-overview'
            ]
        ];
        $request = $this->actingAs($user)
        ->post('dashboard/save-sort', 
            [
                'data'=>$data     
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
    }
}
