<?php
use App\Models\UserModel;
class CreateNewAssetTest extends TestCase{
  
    public function testCreateNewAssetSussessTest(){
        $today = date("Y-m-d H:i:s");     
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-new-asset', 
            [
                'folder'=>'56c499aad6479171778b4568',
                'name'=>'nane new upload asset',
                'fileName' =>'createnew.css',
                'type' =>'css' 
            ]
        );
   
        $request->seeJson([
            'status' => 1
        ]);
    }   
    /**
     * [test Create New Asset Type Not Type Of Foler Test description]
     * @return [type] [description]
     */
    public function testCreateNewAssetTypeNotTypeOfFolerTest(){  
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-new-asset', 
            [
                'folder'=>'56c499aad6479171778b4568',
                'name'=>'nane new upload asset',
                'fileName' =>'createnew.css',
                'type' =>'js' 
            ]
        );
   
        $request->seeJson([
            'status' => 0 
        ]);
    }
     /**
     * [test Create New Asset Not Data Test description]
     * @return [type] [description]
     */
    public function testCreateNewAssetNotDataTest(){  
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-new-asset', 
            [
                
            ]
        );
   
        $request->seeJson([
            'status' => 0 
        ]);
    }
    /**
     * [test Create New Asset Folder Not Type Css Or Js]
     * @return [type] [description]
     */
    public function testCreateNewAssetFolderNotTypeCssOrJsTest(){  
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-new-asset', 
            [
                'folder'=>'56c499aad6479171778b4567',
                'name'=>'nane new upload asset',
                'fileName' =>'createnew.css',
                'type' =>'images' 
            ]
        );
   
        $request->seeJson([
            'status' => 0 
        ]);
    }
    /**
     * [test Create New Asset Folder Not Type Css Or Js]
     * @return [type] [description]
     */
    public function testCreateNewAssetFolderNotExistFolderTest(){  
        $user = UserModel::find(6);
        $request = $this->actingAs($user)
        ->post('api/asset-manager/create-new-asset', 
            [
                'folder'=>'dsdss',
                'name'=>'nane new upload asset',
                'fileName' =>'createnew.css',
                'type' =>'images' 
            ]
        );
   
        $request->seeJson([
            'status' => 0 
        ]);
    }
   
 

}