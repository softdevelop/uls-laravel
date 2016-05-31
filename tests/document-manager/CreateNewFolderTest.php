<?php
use App\Models\UserModel;
class CreateNewFolderTest extends TestCase{
    
    /**
     * [test Create New Folder  Test susscess]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('admin/document-manager/add-folder', 
            [
                'parent_id'=>0,
                'name'=>'tt'.strtotime($today)
            ]
        );
        $request->seeJson([
            'status' => 1
        ]);
        
    }
    /**
     * [test Create New Folder  Not data Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderNotdataTest(){
        
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('admin/document-manager/add-folder', 
            [
                
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Create New Folder  with parent not exist Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderNotExistParentTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('admin/document-manager/add-folder', 
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
     * [test Create New Folder  user not permission Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testCreateNewFolderNotPermissionTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(10);
        $request = $this->actingAs($user)
        ->post('admin/document-manager/add-folder', 
            [
                'parent_id'=>0,
                'name'=>'tt'.strtotime($today)
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
   
 

}