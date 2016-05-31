<?php

use App\Models\UserModel;
class GetAllReleaseVersionTest extends TestCase{
   /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Get all release version
    ---------------------------------------------------------------------------------------------*/
    /**
     * [testGetAllReleaseVersionTest description]
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testGetAllReleaseVersionTest(){
        $user = UserModel::find(6);
        $request = $this->actingAs($user);   
        $response = $this->call('GET', 'site-configuration/release-manager');
        $this->assertEquals(200, $response->getStatusCode());
        $view = $response->original;
    }
}