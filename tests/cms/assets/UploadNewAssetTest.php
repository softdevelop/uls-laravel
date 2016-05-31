<?php
use App\Models\UserModel;
class UploadNewAssetTest extends TestCase{
    /**
     * [testRequestNewPage description]
     * pass data that is used for request new page and expect status of the api is 1
     * @author toan
     * @return [void]
     */
    public function testCreateNewAssetTest(){
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
        $data['folder'] = '56c499aad6479171778b4567';
        $data['name'] = 'Sally'; 
        $data['nameNewFile'] = '1412742_812802045496532_6201700862020987762_o.jpg'; 
        $data['withFile']  =  637;
        $data['heightFile']  =  718;
        $data['type']  =  'image';

        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/upload-new-asset', 
            [
                'data'=>json_encode($data)
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
        
    }
    public function testCreateNewAssetNotFileTest(){
        if(!empty($_FILES['file'])) {

            unset($_FILES['file']);
        }
        if(!empty($_FILES['image'])) {
            
            unset($_FILES['image']);
        }
        
        $data = [];
        $data['folder'] = '56c499aad6479171778b4567';
        $data['name'] = 'Sally'; 
        $data['nameNewFile'] = '1412742_812802045496532_6201700862020987762_o.jpg'; 
        $data['withFile']  =  637;
        $data['heightFile']  =  718;
        $data['type']  =  'image';
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/upload-new-asset', 
            [
                'data'=>json_encode($data)
            ]
        );
        // $request->dump();
        
        $request->seeJson([
            'status' => 0
        ]);
        
    }
    public function testCreateNewAssetNotDataTest(){
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
        ->post('api/asset-manager/upload-new-asset', 
            [
                'data'=>json_encode($data)
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
    }  
    public function testCreateNewAssetNotFolderTest(){
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
        $data['folder'] = 'saassss';
        $data['name'] = 'Sally'; 
        $data['nameNewFile'] = '1412742_812802045496532_6201700862020987762_o.jpg'; 
        $data['withFile']  =  637;
        $data['heightFile']  =  718;
        $data['type']  =  'image';

        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/upload-new-asset', 
            [
                'data'=>json_encode($data)
            ]
        );
   
        $request->seeJson([
            'status' => 0
        ]);
    }   
 
 

}