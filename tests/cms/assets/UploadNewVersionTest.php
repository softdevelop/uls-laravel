<?php
use App\Models\UserModel;
class UploadNewVersionTest extends TestCase{
  
    /**
     * [test Upload New Version Test susses]
     * @return [type] [description]
     */
    public function testUploadNewVersionTest(){
        if(!empty($_FILES['file'])) {

            unset($_FILES['file']);
        }
        if(!empty($_FILES['image'])) {
            
            unset($_FILES['image']);
        }
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

        $data = [];
        $data['_id'] = '571dd9d095b0d627b8003a98';
        $data['name'] = 'cxcxcc'; 
        $data['tags'] = ["56ab61dfdf357681368b4569"]; 
        $data['alt_tag'] = 'fd'; 
        $data['description'] = 'fdd'; 
        $data['filename'] = '600x900.jpg'; 
        $data['folder_id'] = '56c499aad6479171778b4567'; 
        $data['folder'] = '56c499aad6479171778b4567'; 
        $data['language'] = 'en'; 
        $data['region'] = null; 
        $data['status'] = 'uptodate'; 
        $data['ancestor_ids'] = ["571dd9d095b0d627b8003a98","56c499aad6479171778b4567","56c499a8d6479169778b4567","0"]; 
        $data['nameNewFile']  =  '1412742_812802045496532_6201700862020987762_o.jpg';
        $data['thumbnailsMedium']  = "100x100";
        $data['withFile']  = 637;
        $data['thumbnailsSmall']  =  "64x64";
        $data['thumbnailsMaterial']  =  "75x75";
        $data['thumbnailsProduct']  =  "82x82";
        $data['withFile']  =  637;
        $data['heightFile']  =  718;
        $data['type']  =  'image';
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/edit-file', 
            [

                "data" => json_encode($data),
                "file" => ""
            ]
        );
        $request->seeJson([
            'status' => 1
        ]);
    }  
     /**
     * [test Upload New Version Empty DataTest]
     * @return [type] [description]
     */
    public function testUploadNewVersionEmptyDataTest(){
        if(!empty($_FILES['file'])) {

            unset($_FILES['file']);
        }
        if(!empty($_FILES['image'])) {
            
            unset($_FILES['image']);
        }
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

        $data = [];
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/edit-file', 
            [

            ]
        );
        $request->seeJson([
            'status' => 0
        ]);
    }
    /**
     * [test Upload New Version Not Field Requies Test]
     * @return [type] [description]
     */
    public function testUploadNewVersionNotFieldRequiesTest(){
        if(!empty($_FILES['file'])) {

            unset($_FILES['file']);
        }
        if(!empty($_FILES['image'])) {
            
            unset($_FILES['image']);
        }
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

        $data = [];
        $data['_id'] = '570ca36495b0d61f3c00308b';
        $data['tags'] = ["56ab61dfdf357681368b4569"]; 
        $data['alt_tag'] = 'fd'; 
        $data['description'] = 'fdd'; 
        $data['language'] = 'en'; 
        $data['region'] = null; 
        $data['status'] = 'uptodate'; 
        $data['ancestor_ids'] = ["5708c62095b0d60b08007054","56c499aad6479171778b4567","56c499a8d6479169778b4567","0"]; 
        $data['nameNewFile']  =  '1412742_812802045496532_6201700862020987762_o.jpg';
        $data['thumbnailsMedium']  = "100x100";
        $data['withFile']  = 637;
        $data['thumbnailsSmall']  =  "64x64";
        $data['thumbnailsMaterial']  =  "75x75";
        $data['thumbnailsProduct']  =  "82x82";
        $data['withFile']  =  637;
        $data['heightFile']  =  718;
        $data['type']  =  'image';
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/edit-file', 
            [

                "data" => json_encode($data),
                "file" => ""
            ]
        );
        $request->seeJson([
            'status' => 0
        ]);
    }
    /**
     * [test Upload New Version Not Exist Folder Test]
     * @return [type] [description]
     */
    public function testUploadNewVersionNotExistFolderTest(){
        if(!empty($_FILES['file'])) {

            unset($_FILES['file']);
        }
        if(!empty($_FILES['image'])) {
            
            unset($_FILES['image']);
        }
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

        $data = [];
        $data['_id'] = '570ca36495b0d61f3c00308b';
        $data['name'] = 'cxcxcc'; 
        $data['tags'] = ["56ab61dfdf357681368b4569"]; 
        $data['alt_tag'] = 'fd'; 
        $data['description'] = 'fdd'; 
        $data['filename'] = '600x900.jpg'; 
        $data['folder_id'] = 'sd'; 
        $data['folder'] = 'aaa'; 
        $data['language'] = 'en'; 
        $data['region'] = null; 
        $data['status'] = 'uptodate'; 
        $data['ancestor_ids'] = ["5708c62095b0d60b08007054","56c499aad6479171778b4567","56c499a8d6479169778b4567","0"]; 
        $data['nameNewFile']  =  '1412742_812802045496532_6201700862020987762_o.jpg';
        $data['thumbnailsMedium']  = "100x100";
        $data['withFile']  = 637;
        $data['thumbnailsSmall']  =  "64x64";
        $data['thumbnailsMaterial']  =  "75x75";
        $data['thumbnailsProduct']  =  "82x82";
        $data['withFile']  =  637;
        $data['heightFile']  =  718;
        $data['type']  =  'image';
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/edit-file', 
            [
                "data" => json_encode($data),
                "file" => ""
            ]
        );
        $request->seeJson([
            'status' => 0
        ]);
    }        
    
}