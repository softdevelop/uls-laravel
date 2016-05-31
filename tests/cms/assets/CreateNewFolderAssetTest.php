<?php
use App\Models\UserModel;
class CreateNewFolderAssetTest extends TestCase{
    
    /**
     * [test Create New Folder Asset Test susscess]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderAssetTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-folder', 
            [
                'parent_id'=>'56c499aad6479171778b4567',
                'name'=>'tt'.strtotime($today)
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
        
    }
    /**
     * [test Create New Folder Asset Not data Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderAssetNotdataTest(){
        
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-folder', 
            [
                
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Create New Folder Asset with parent not exist Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderAssetNotExistParentTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-folder', 
            [
                'parent_id'=>'1223',
                'name'=>'tt'.strtotime($today)
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Create New Folder Asset with parent root Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderAssetParentRootTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-folder', 
            [
                'parent_id'=>'56c499a8d6479169778b4567',
                'name'=>'tt'.strtotime($today)
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Create New Folder Asset with name folder exist into parent folder Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderAssetNameExistIntoParentTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-folder', 
            [
                'parent_id'=>'56c499aad6479171778b4567',
                'name'=>'tt1459502529'
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
 
 

}