<?php
use App\Models\UserModel;
class VisibleFolderTest extends TestCase{
    
    /**
     * [test Visible Folder Not Exist Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testVisibleFolderNotExistTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('admin/document-manager/visible-folder/asasssas', 
            [
            ]
        );
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    
    /**
     * [test Visible Folder  user not permission Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testVisibleFolderNotPermissionTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(10);
        $request = $this->actingAs($user)
        ->post('admin/document-manager/visible-folder/66', 
            [
               
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
     /**
     * [test Visible Folder Success Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testVisibleFolderSuccessTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('admin/document-manager/visible-folder/66', 
            [
               
            ]
        );
   
        $request->seeJson([
            'status' => true
        ]);
        
    }
   
 

}