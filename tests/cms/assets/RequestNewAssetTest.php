<?php
use App\Models\UserModel;
class RequestNewAssetTest extends TestCase{
    
    /**
     * [test Request New Asset susscess]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetSussesTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
                "ticket_type" => "create_new_asset",
                "name" => "dsdds",
                "folder_id" => "56c499aad6479171778b4568",
                "due_date" => "2016-05-18T17:00:00.000Z",
                "description" => "<div>dsd</div>",
                "status" => "waiting-approve"
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
        
    }
    /**
     * [test Request New Asset NotData]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetNotDataTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
                /*"ticket_type" => "create_new_asset",
                "name" => "dsdds",
                "folder_id" => "56c499aad6479171778b4568",
                "due_date" => "2016-05-18T17:00:00.000Z",
                "description" => "<div>dsd</div>",
                "status" => "waiting-approve"*/
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Request New Asset Not One Item Data]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetNotOneItemDataTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
               /* "ticket_type" => "create_new_asset",*/
                "name" => "dsdds",
                "folder_id" => "56c499aad6479171778b4568",
                "due_date" => "2016-05-18T17:00:00.000Z",
                "description" => "<div>dsd</div>",
                "status" => "waiting-approve"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Request New Asset Type Ticket Is Not Create New Asset Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetTypeTicketIsNotCreateNewAssetTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
                "ticket_type" => "aa",
                "name" => "dsdds",
                "folder_id" => "56c499aad6479171778b4568",
                "due_date" => "2016-05-18T17:00:00.000Z",
                "description" => "<div>dsd</div>",
                "status" => "waiting-approve"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
     /**
     * [test Request New Asset Due DateS maller Date Now Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetDueDateSmallerDateNowTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
                "ticket_type" => "create_new_asset",
                "name" => "dsdds",
                "folder_id" => "56c499aad6479171778b4568",
                "due_date" => "2016-04-6T17:00:00.000Z",
                "description" => "<div>dsd</div>",
                "status" => "waiting-approve"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Request New Asset Due Date Note Date Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetDueDateNoteDateTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
                "ticket_type" => "create_new_asset",
                "name" => "dsdds",
                "folder_id" => "56c499aad6479171778b4568",
                "due_date" => "sâsa",
                "description" => "<div>dsd</div>",
                "status" => "waiting-approve"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Request New Asset Status Is Not Waiting ApproveTest]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetStatusIsNotWaitingApproveTest(){  
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
                "ticket_type" => "create_new_asset",
                "name" => "dsdds",
                "folder_id" => "56c499aad6479171778b4568",
                "due_date" => "sâsa",
                "description" => "<div>dsd</div>",
                "status" => "Live"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
     /**
     * [test Request New Asset folder not exists Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testRequestNewAssetFolderNotExistTest(){  
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager', 
            [
                "ticket_type" => "create_new_asset",
                "name" => "dsdds",
                "folder_id" => "dssdsdd",
                "due_date" => "sâsa",
                "description" => "<div>dsd</div>",
                "status" => "Live"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    
 

}