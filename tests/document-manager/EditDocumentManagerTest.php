<?php
use App\Models\UserModel;
class EditDocumentManagerTest extends TestCase{
    
    /**
     * [test Create New Folder  Test susscess]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testEditNameFolderNotDataTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->put('admin/document-manager/edit-file-name/72', 
            [
              
            ]
        );
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    /**
     * [test Create New Folder  Not data Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testEditNameFileNotDataTest(){
        
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->put('admin/document-manager/edit-file-name/136', 
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
    public function testEditFolderVisilbeAndNotPermissionTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(10);
        $request = $this->actingAs($user)
        ->put('admin/document-manager/edit-file-name/53', 
            [
                "fileName" => "ddsddsdsdsd",
                "group" => "folder"
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
        ->put('admin/document-manager/edit-file-name/160', 
            [
                "fileName" => "fdfdfd.jpg",
                "group" => "file"
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
    public function testEditFileNameOfFileIsDeleteTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->put('admin/document-manager/edit-file-name/aaassa', 
            [
                "fileName" => "fdfdfd.jpg",
                "group" => "file"
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
    public function testEditFolderNameOfFolderIsDeleteTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->put('admin/document-manager/edit-file-name/aaaaa', 
            [
                "fileName" => "ddsddsdsdsd",
                "group" => "folder"
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
    public function testEditFolderSuccessTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->put('admin/document-manager/edit-file-name/72', 
            [
                "fileName" => "ddsddsdsdsd",
                "group" => "folder"
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
        
    }
     /**
     * [test Create New Folder  user not permission Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testEditFileSuccessTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->put('admin/document-manager/edit-file-name/136', 
            [
                "fileName" => "fdfdfd.jpg",
                "group" => "file"
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
        
    }
   
 

}