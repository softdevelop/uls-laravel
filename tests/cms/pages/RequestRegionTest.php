<?php

use App\Models\UserModel;
use App\Models\LanguageModel;
use App\Models\RegionModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ReleaseVersionModelMongo;
use Carbon\Carbon;

class RequestRegionTest extends TestCase
{

    /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test request region of page expect true
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request region
     *
     * Test request region with expect success
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Object Page
     */
    public function testRequestRegionWithExpectSuccess ()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'content_id' => $defaultContent->_id,
                        'due_date' => $date,
                        'language' => 'en',
                        'regions' => $regionArray,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );

                $return = json_decode($request->response->getContent(), true);
                
                $request->seeJson([
                    'status' => 1
                ]);    

                return $return['page'];
            }
        }
    }

    /**
     * @depends testRequestRegionWithExpectSuccess
     * 
     * Test request region and create tickets
     * 
     * Test request region of page and create child tickets
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testCreatedChildTicketsWhenRequestRegionExpectTicketCreatedSuccess($page)
    {
        $tickets = TicketModel::where('content_id', $page['contents'][0]['_id'])->first();

        $this->assertNotEquals($tickets, []);  
    }

    /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test request region of page with emtype value
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request region with empty page id
     *
     * Test request region with empty page id with status response from api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyPageIdExpectFail ()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        'name' => $page->name,
                        'content_id' => $defaultContent->_id,
                        'due_date' => $date,
                        'language' => 'en',
                        'regions' => $regionArray,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);  
            }
        }
    }

    /**
     * Test request region with empty page name
     *
     * Test request region with empty page name with status response from api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyPageNameExpectFail ()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        '_id' => $page->_id,
                        'content_id' => $defaultContent->_id,
                        'due_date' => $date,
                        'language' => 'en',
                        'regions' => $regionArray,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);    
            }
        }
    }

    /**
     * Test request region with empty content id
     *
     * Test request region with empty content id with noContentId response from api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyContentIdExpectFail ()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'due_date' => $date,
                        'language' => 'en',
                        'regions' => $regionArray,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'noContentId' => 1
                ]);    
            }
        }
    }
    
    /**
     * Test request region with empty due date
     *
     * Test request region with empty due date with status response from api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyDueDateExpectFail()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'content_id' => $defaultContent->_id,
                        'language' => 'en',
                        'regions' => $regionArray,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);    
            }
        }
    }
    
    /**
     * Test request region with empty language
     *
     * Test request region with empty language with status response from api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyLanguageExpectFail ()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // Region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'content_id' => $defaultContent->_id,
                        'due_date' => $date,
                        'regions' => $regionArray,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);    
            }
        }
    }

    /**
     * Test request region with empty region
     *
     * Test request region with empty region with status response from api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyRegionExpectFail ()
    {
        // Get pages not Page root
        $page = PageModelMongo::where('parent_id', '!=', '0')->first();

        $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

        $date = Carbon::now();

        $version = ReleaseVersionModelMongo::get()->max('version');

        $user = UserModel::find(6);

        $request = $this->actingAs($user)
        ->post('api/pages/request-region', 
            [
                '_id' => $page->_id,
                'name' => $page->name,
                'content_id' => $defaultContent->_id,
                'due_date' => $date,
                'language' => 'en',
                'version' => $version + 0.1,
                'description' => 'Test case'
            ]
        );
        
        $request->seeJson([
            'status' => 0
        ]);    
    }

    /**
     * Test request region with empty version
     *
     * Test request region with empty version with noVersion response from api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyVersionExpectFail ()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'content_id' => $defaultContent->_id,
                        'due_date' => $date,
                        'language' => 'en',
                        'regions' => $regionArray,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'noVersion' => 1
                ]);    
            }
        }
    }

    /**
     * Test request region with empty description
     *
     * Test request region with empty description with status response from api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    public function testRequestRegionWithEmptyDescriptionExpectFail ()
    {
        // Get pages not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        foreach ($pages as $page) {

            // Get content default
            $defaultContent = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

            // Get regions code of content has language is en
            $regionsCode = $page->cmsContent()->where('language', 'en')->select('region')->get()->toArray();

            // Format regions code array
            $regionsCode = array_flatten(array_column($regionsCode, 'region'));
            $regionsCode[array_search(null, $regionsCode)] = 'us';

            // Regions code
            $regions = array_flatten(RegionModel::select('code')->get()->toArray());

            // region not in regions code array of content has language is en
            $regionArray = array_diff($regions, $regionsCode);

            if (!empty($regionArray)) {

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-region', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'content_id' => $defaultContent->_id,
                        'due_date' => $date,
                        'language' => 'en',
                        'regions' => $regionArray,
                        'version' => $version + 0.1
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);    
            }
        }
    }
}