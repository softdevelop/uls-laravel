<?php
use App\Models\UserModel;
class UploadFileDocumentManagerTest extends TestCase{
    
    /**
     * [test Visible Folder Not Exist Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testFolderNotExistTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $local_file =  base_path(). '/tests/test-files/1412742_812802045496532_6201700862020987762_o.jpg';
        $_FILES = array(
             'file' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
            'image' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
        );
        $request = $this->actingAs($user)
        ->post('admin/document-manager', 
            [
                'folderId'=>"asss",
                'store'=>"graphic"
            ]
        );
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    
    /**
     * [test Visible Folder  and user not permission Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testVisibleFolderAndNotPermissionTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(10);
        $local_file =  base_path(). '/tests/test-files/1412742_812802045496532_6201700862020987762_o.jpg';
        $_FILES = array(
             'file' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
            'image' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
        );
        $request = $this->actingAs($user)
        ->post('admin/document-manager', 
            [
               'folderId'=>54,
                'store'=>"graphic"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }
     /**
     * [test Store Not Graphic Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
  /*  public function testStoreNotGraphicTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $_FILES = array(
             'file' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
            'image' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
        );
        $request = $this->actingAs($user)
        ->post('admin/document-manager', 
            [
                'folderId'=>53,
                'store'=>"asa"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }*/
    /**
     * [test Store Not Graphic Success Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testNotFileTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        if(!empty($_FILES['file'])) {

            unset($_FILES['file']);
        }
        if(!empty($_FILES['image'])) {
            
            unset($_FILES['image']);
        }
        $request = $this->actingAs($user)
        ->post('admin/document-manager', 
            [
                'folderId'=>54,
                'store'=>"asa"
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
        
    }

    /**
     * [ test Upload Success Test]
     * @author [vanlinh] <[<vanlinh@httsolution.com>]>
     */
    public function testUploadSuccessTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $local_file =  base_path(). '/tests/test-files/1412742_812802045496532_6201700862020987762_o.jpg';
        $_FILES = array(
             'file' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
            'image' => array (
                'tmp_name' => $local_file,
                'name' => '1412742_812802045496532_6201700862020987762_o.jpg',
                'type' => 'image/jpeg',
                'size' => 335057,
                'error' => 0,
            ),
        );
        $request = $this->actingAs($user)
        ->post('admin/document-manager', 
            [
               'folderId'=>54,
                'store'=>"graphic"
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
    }  
   
   
 

}