<?php

use App\Models\UserModel;
use App\Models\LanguageModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ReleaseVersionModelMongo;
use Carbon\Carbon;

class RequestTranslateTest extends TestCase
{

    /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test request translation of page expect true
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request translation page
     * 
     * pass data that is used for request new page and expect status of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testTranslationPageExpectSuccess()
    {
        // Get all page not Page root
    	$pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        // Each page
        foreach ($pages as $page) {

            $contents = $page->cmsContent()->select('status')->get()->toArray();

            $checkContentLive = array_search('live', array_column($contents, 'status'));

            if ($checkContentLive !== false) {

                $contentDefault = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

                $contentsOfPage = $page->cmsContent;

                // Languages code of contents page
                $languagesCodeOfContentsPage = array_column($contentsOfPage->toArray(), 'language');

                // All languages name and languages code 
                $languages = LanguageModel::select('name', 'code')->whereNotIn('code', $languagesCodeOfContentsPage)->get()->toArray();

                $languageChoose = [];
                $languageChoose[$languages[0]['name']] = $languages[0]['code'];

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-translation', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'due_date' => $date,
                        'languages' => $languageChoose,
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
        };
    }

    /**
     * @depends testTranslationPageExpectSuccess
     * 
     * Test request new page
     * 
     * Test create page and create child tickets
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testCreatedChildTicketsWhenRequestTranslationExpectTicketCreatedSuccess($page)
    {
        $tickets = TicketModel::where('content_id', $page['contents'][0]['_id'])->first();

        $this->assertNotEquals($tickets, []);  
    }

    /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test request translation of page expect false
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request translation page
     * 
     * pass data that is used for request new page and expect contentNoLive of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testTranslationPageWithPageNotHasContentLiveExpectFail()
    {
        // Get all page not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        // Each page
        foreach ($pages as $page) {

            $contents = $page->cmsContent()->select('status')->get()->toArray();

            $checkContentLive = array_search('live', array_column($contents, 'status'));

            if ($checkContentLive === false) {

                $contentDefault = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

                $contentsOfPage = $page->cmsContent;

                // Languages code of contents page
                $languagesCodeOfContentsPage = array_column($contentsOfPage->toArray(), 'language');

                // All languages name and languages code 
                $languages = LanguageModel::select('name', 'code')->whereNotIn('code', $languagesCodeOfContentsPage)->get()->toArray();

                $languageChoose = [];
                $languageChoose[$languages[0]['name']] = $languages[0]['code'];

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-translation', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'due_date' => $date,
                        'languages' => $languageChoose,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'contentNoLive' => 1
                ]);    
            }
        };
    }

    /**
     * Test request translation page with empty page id
     * 
     * pass data that is used for request new page and expect emptyPageId of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testTranslationPageWithEmtypePageIdExpectFail()
    {
        // Get all page not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        // Each page
        foreach ($pages as $page) {

            $contents = $page->cmsContent()->select('status')->get()->toArray();

            $checkContentLive = array_search('live', array_column($contents, 'status'));

            if ($checkContentLive !== false) {

                $contentDefault = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

                $contentsOfPage = $page->cmsContent;

                // Languages code of contents page
                $languagesCodeOfContentsPage = array_column($contentsOfPage->toArray(), 'language');

                // All languages name and languages code 
                $languages = LanguageModel::select('name', 'code')->whereNotIn('code', $languagesCodeOfContentsPage)->get()->toArray();

                $languageChoose = [];
                $languageChoose[$languages[0]['name']] = $languages[0]['code'];

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-translation', 
                    [
                        'name' => $page->name,
                        'due_date' => $date,
                        'languages' => $languageChoose,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'emptyPageId' => 1
                ]);    
            }
        };
    }
    

    /**
     * Test request translation page with empty page name
     * 
     * pass data that is used for request new page and expect status of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testTranslationPageWithEmtypePageNameExpectFail()
    {
        // Get all page not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        // Each page
        foreach ($pages as $page) {

            $contents = $page->cmsContent()->select('status')->get()->toArray();

            $checkContentLive = array_search('live', array_column($contents, 'status'));

            if ($checkContentLive !== false) {

                $contentDefault = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

                $contentsOfPage = $page->cmsContent;

                // Languages code of contents page
                $languagesCodeOfContentsPage = array_column($contentsOfPage->toArray(), 'language');

                // All languages name and languages code 
                $languages = LanguageModel::select('name', 'code')->whereNotIn('code', $languagesCodeOfContentsPage)->get()->toArray();

                $languageChoose = [];
                $languageChoose[$languages[0]['name']] = $languages[0]['code'];

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-translation', 
                    [
                        '_id' => $page->_id,
                        'due_date' => $date,
                        'languages' => $languageChoose,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);    
            }
        };
    }

    /**
     * Test request translation page with empty due_date
     * 
     * pass data that is used for request new page and expect status of the api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testTranslationPageWithEmtypeDueDateExpectFail()
    {
        // Get all page not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        // Each page
        foreach ($pages as $page) {

            $contents = $page->cmsContent()->select('status')->get()->toArray();

            $checkContentLive = array_search('live', array_column($contents, 'status'));

            if ($checkContentLive !== false) {

                $contentDefault = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

                $contentsOfPage = $page->cmsContent;

                // Languages code of contents page
                $languagesCodeOfContentsPage = array_column($contentsOfPage->toArray(), 'language');

                // All languages name and languages code 
                $languages = LanguageModel::select('name', 'code')->whereNotIn('code', $languagesCodeOfContentsPage)->get()->toArray();

                $languageChoose = [];
                $languageChoose[$languages[0]['name']] = $languages[0]['code'];

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-translation', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'languages' => $languageChoose,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);    
            }
        };
    }

    /**
     * Test request translation page with empty language
     * 
     * pass data that is used for request new page and expect status of the api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testTranslationPageWithEmtypeLanguageExpectFail()
    {
        // Get all page not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        // Each page
        foreach ($pages as $page) {

            $contents = $page->cmsContent()->select('status')->get()->toArray();

            $checkContentLive = array_search('live', array_column($contents, 'status'));

            if ($checkContentLive !== false) {

                $contentDefault = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

                $contentsOfPage = $page->cmsContent;

                // Languages code of contents page
                $languagesCodeOfContentsPage = array_column($contentsOfPage->toArray(), 'language');

                // All languages name and languages code 
                $languages = LanguageModel::select('name', 'code')->whereNotIn('code', $languagesCodeOfContentsPage)->get()->toArray();

                $languageChoose = [];
                $languageChoose[$languages[0]['name']] = $languages[0]['code'];

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-translation', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'due_date' => $date,
                        'version' => $version + 0.1,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'status' => 0
                ]);    
            }
        };
    }

    /**
     * Test request translation page with empty version
     * 
     * pass data that is used for request new page and expect noVersion of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testTranslationPageWithEmtypeVersionExpectFail()
    {
        // Get all page not Page root
        $pages = PageModelMongo::where('parent_id', '!=', '0')->get();

        // Each page
        foreach ($pages as $page) {

            $contents = $page->cmsContent()->select('status')->get()->toArray();

            $checkContentLive = array_search('live', array_column($contents, 'status'));

            if ($checkContentLive !== false) {

                $contentDefault = $page->cmsContent()->where('language', 'en')->where('region', null)->first();

                $contentsOfPage = $page->cmsContent;

                // Languages code of contents page
                $languagesCodeOfContentsPage = array_column($contentsOfPage->toArray(), 'language');

                // All languages name and languages code 
                $languages = LanguageModel::select('name', 'code')->whereNotIn('code', $languagesCodeOfContentsPage)->get()->toArray();

                $languageChoose = [];
                $languageChoose[$languages[0]['name']] = $languages[0]['code'];

                $date = Carbon::now();

                $version = ReleaseVersionModelMongo::get()->max('version');

                $user = UserModel::find(6);

                $request = $this->actingAs($user)
                ->post('api/pages/request-translation', 
                    [
                        '_id' => $page->_id,
                        'name' => $page->name,
                        'due_date' => $date,
                        'languages' => $languageChoose,
                        'description' => 'Test case'
                    ]
                );
                
                $request->seeJson([
                    'noVersion' => 1
                ]);    
            }
        };
    }
}