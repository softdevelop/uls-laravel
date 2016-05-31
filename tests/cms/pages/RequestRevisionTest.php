<?php

use App\Models\UserModel;
use App\Models\RegionModel;
use App\Models\LanguageModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ReleaseVersionModelMongo;
use Carbon\Carbon;

class RequestRevisionTest extends TestCase
{
	/*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test request revision of page expect true
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request revision
     *
     * Test request revision with expect success
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Object Page
     */
    public function testRequestRevisionWithExpectSuccess ()
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
}