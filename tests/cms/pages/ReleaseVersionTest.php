<?php

use App\Models\UserModel;
use Rowboat\ContentManagement\Models\Mongo\ReleaseVersionModelMongo;

class ReleaseVersionTest extends TestCase
{
    /**
     * testCreateNewReleaseVersionExpectSuccess
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testCreateNewReleaseVersionExpectSuccess() 
    {
        $user = UserModel::find(10);

        $releaseVersion = ReleaseVersionModelMongo::orderBy('created_at', 'desc')->first();

        $request = $this->actingAs($user)
        ->post('api/release-version', 
            [
                'version' => $releaseVersion->version + 0.1,
                'description' => 'Test create new release version'
            ]
        );

        $request->seeJson([
            'status' => 1
        ]);     
    }

    /**
     * testCreateNewReleaseVersionMissedVersionExpectFail
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testCreateNewReleaseVersionMissedVersionExpectFail() 
    {
        $user = UserModel::find(10);

        $request = $this->actingAs($user)
        ->post('api/release-version', 
            [
                'description' => 'Test create new release version'
            ]
        );

        $request->seeJson([
            'status' => 0
        ]);    
    }

    /**
     * testCreateNewReleaseVersionMissedDescriptionExpectFail
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testCreateNewReleaseVersionMissedDescriptionExpectFail() 
    {
        $user = UserModel::find(10);

        $request = $this->actingAs($user)
        ->post('api/release-version', 
            [
                'version' => 1.0
            ]
        );
        
        $request->seeJson([
            'status' => 0
        ]);    
    }

    /**
     * testUpdateReleaseVersionExpectTrue
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testUpdateReleaseVersionExpectTrue() 
    {
        $user = UserModel::find(10);

        $releaseVersion = ReleaseVersionModelMongo::first();

        $request = $this->actingAs($user)
        ->put('api/release-version/' . $releaseVersion->_id, 
            [
                '_id' => $releaseVersion->_id,
                'description' => 'Test update release version 1'
            ]
        );

        $request->seeJson([
            'status' => 1
        ]);    
    }

    /**
     * testUpdateReleaseVersionMissedDescriptionExpectFail
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testUpdateReleaseVersionMissedDescriptionExpectFail() 
    {
        $user = UserModel::find(10);

        $releaseVersion = ReleaseVersionModelMongo::first();

        $request = $this->actingAs($user)
        ->put('api/release-version/' . $releaseVersion->_id, 
            [
                '_id' => $releaseVersion->_id
            ]
        );
        
        $request->seeJson([
            'status' => 0
        ]);    
    }

    /**
     * testDeleteReleaseVersionMissedDescriptionExpectTrue
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testDeleteReleaseVersionExpectTrue() 
    {
        $user = UserModel::find(10);

        $releaseVersion = ReleaseVersionModelMongo::first();

        $request = $this->actingAs($user)
        ->delete('api/release-version/' . $releaseVersion->_id);
        
        $request->seeJson([
            'status' => 1
        ]);    
    }

    /**
     * testDeleteReleaseVersionMissedDescriptionExpectTrue
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void 
     */
    public function testDeleteReleaseVersionMissedIdExpectFalse() 
    {
        $user = UserModel::find(10);

        $request = $this->actingAs($user)

        ->delete('api/release-version/' . '123');
        
        $request->seeJson([
            'status' => 0
        ]);    
    }
}