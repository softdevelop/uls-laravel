<?php
use App\Models\UserModel;
class DeleteDocumentManagerTest extends TestCase{
    

    /**
     * [test Delete Folder Visilbe And Not Permission Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testDeleteFolderVisilbeAndNotPermissionTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(10);
        $request = $this->actingAs($user)
        ->delete('admin/document-manager/delete-folder/53', 
            [
              
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
    public function testEditFileOfFolderVisilbeAndNotPermissionTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(10);
        $request = $this->actingAs($user)
        ->delete('admin/document-manager/160', 
            [
                
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
     /**
     * [test Delete File  Is Delete Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testDeleteFileIsDeleteTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->delete('admin/document-manager/aaassa', 
            [
               
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
     /**
     * [test Delete Folder Is Delete Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testDeleteFolderIsDeleteTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->delete('admin/document-manager/delete-folder/aaaaa', 
            [
               
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
     /**
     * [test Delete Folder Success Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testDeleteFolderSuccessTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->delete('admin/document-manager/delete-folder/80', 
            [
               
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
        
    }
     /**
     * [test Delete File Success Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testDeleteFileSuccessTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->delete('admin/document-manager/126', 
            [
                "fileName" => "fdfdfd.jpg",
                "group" => "file"
            ]
        );
   
        $request->seeJson([
            'status' => true
        ]);
        
    }
   
 

}