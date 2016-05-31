<?php

use App\Models\UserModel;
use Rowboat\Ticket\Models\TicketModel;
use Rowboat\ContentManagement\Models\Mongo\PageModelMongo;
use Rowboat\ContentManagement\Models\Mongo\ReleaseVersionModelMongo;
use Carbon\Carbon;

class ProposeNewPageTest extends TestCase
{

    /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test create new page
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request new page
     * 
     * pass data that is used for request new page and expect status of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testRequestNewPageExpectSuccess()
    {
        $faker = Faker\Factory::create();

        $version = ReleaseVersionModelMongo::get()->max('version');

        $user = UserModel::find(6);

        $page = PageModelMongo::where('parent_id', '0')->first();

        $date = Carbon::now();

        $request = $this->actingAs($user)
        ->post('api/pages', 
            [
                'name' => $faker->name,
                'version' => $version + 0.1,
                'parent_id' => $page->_id,
                'due_date' => $date,
                'description' => 'Test case'
            ]
        );

        $return = json_decode($request->response->getContent(),true);
        
        $request->seeJson([
            'status' => 1
        ]);    

        return $return['page'];
    }

    /**
     * @depends testRequestNewPageExpectSuccess
     * 
     * Test request new page
     * 
     * Test create page and create child tickets
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @return Void
     */
    public function testCreatedChildTicketsWhenCreatePageExpectTicketCreatedSuccess($page)
    {
        $tickets = TicketModel::where('content_id', $page['contents'][0]['_id'])->first();

        $this->assertNotEquals($tickets, []);  
    }

    /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test create new page with missed field
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request new page missed name with result status is false
     * 
     * Pass data that is used for request new page and expect status of the api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *         
     * @return Void
     */
    public function testRequestNewPageMissedNameExpectStatusIsFalse()
    {
        $user = UserModel::find(10);

        $version = ReleaseVersionModelMongo::get()->max('version');

        $page = PageModelMongo::where('parent_id', '!=', '0')->first();

        $date = Carbon::now();

        $request = $this->actingAs($user)
        ->post('api/pages', [
            'parent_id' => $page->_id,
            'version' => $version + 0.1,
            'due_date' => $date,
            'description' => 'Test case'
        ]);
        
        $request->seeJson([
            'status' => 0
        ]);
        
    }

    /**
     * Test request new page missed version with result emptyVersion is true
     * 
     * Pass data that is used for request new page and expect emptyVersion of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *         
     * @return Void
     */
    public function testRequestNewPageMissedVersionExpectEmptyVersionIsTrue()
    {
        $faker = Faker\Factory::create();

        $user = UserModel::find(10);

        $page = PageModelMongo::where('parent_id', '!=', '0')->first();

        $date = Carbon::now();

        $request = $this->actingAs($user)
        ->post('api/pages', [
            'name' => $faker->name,
            'parent_id' => $page->_id,
            'due_date' => $date,
            'description' => 'Test case'
        ]);
        
        $request->seeJson([
            'emptyVersion' => 1
        ]);
        
    }

    /**
     * Test request new page missed type with result status is false
     * 
     * Pass data that is used for request new page and expect status of the api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *         
     * @return Void
     */
    public function testRequestNewPageMissedTypeExpectStatusIsFalse ()
    {
        $faker = Faker\Factory::create();

        $version = ReleaseVersionModelMongo::get()->max('version');

        $user = UserModel::find(10);

        $date = Carbon::now();

        $request = $this->actingAs($user)
        ->post('api/pages', [
            'name' => $faker->name,
            'version' => $version + 0.1,
            'due_date' => $date,
            'description' => 'Test case'
        ]);

        $request->seeJson([
            'status' => 0
        ]);
    }
    
    /**
     * Test request new page missed request date with result status is false
     * 
     * Pass data that is used for request new page and expect status of the api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *         
     * @return Void
     */
    public function testRequestNewPageWithEmptyDateRequestExpectStatusIsFalse()
    {
        $faker = Faker\Factory::create();

        $version = ReleaseVersionModelMongo::get()->max('version');

        $page = PageModelMongo::where('parent_id', '0')->first();

        $user = UserModel::find(10);

        $request = $this->actingAs($user)
        ->post('api/pages', [
            'name' => $faker->name,
            'parent_id' => $page->_id,
            'version' => $version + 0.1,
            'description' => 'Test case'
        ]);
        
        $request->seeJson([
            'status' => 0
        ]); 
    }

    /**
     * Test request new page missed version with result status is false
     * 
     * Pass data that is used for request new page and expect status of the api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *         
     * @return Void
     */
    public function testRequestNewPageWithEmptyVersionExpectStatusIsFalse()
    {
        $faker = Faker\Factory::create();

        $user = UserModel::find(10);

        $date = Carbon::now();

        $page = PageModelMongo::where('parent_id', '0')->first();

        $request = $this->actingAs($user)
        ->post('api/pages', [
            'name' => $faker->name,
            'parent_id' => $page->_id,
            'due_date' => $date,
            'description' => 'Test case'
        ]);
        
        $request->seeJson([
            'status' => 0
        ]); 
    }

    /**
     * Test request new page missed description with result status is false
     * 
     * Pass data that is used for request new page and expect status of the api is 0
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *         
     * @return Void
     */
    public function testRequestNewPageWithEmptyDescriptionExpectStatusIsFalse()
    {
        $faker = Faker\Factory::create();

        $user = UserModel::find(10);

        $date = Carbon::now();

        $version = ReleaseVersionModelMongo::get()->max('version');

        $page = PageModelMongo::where('parent_id', '0')->first();

        $request = $this->actingAs($user)
        ->post('api/pages', [
            'name' => $faker->name,
            'version' => $version,
            'parent_id' => $page->_id,
            'due_date' => $date,
        ]);
        
        $request->seeJson([
            'status' => 0
        ]); 
    }


    /*--------------------------------------------------------------------------------------------
    |    @author:      Thanh Tuan <tuan@httsolution.com>
    |    Feature:      Test create new page with file name is exists
    ---------------------------------------------------------------------------------------------*/
    /**
     * Test request new page missed description with result checkName is true
     * 
     * Pass data that is used for request new page and expect checkName of the api is 1
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     *         
     * @return Void
     */
    public function testRequestNewPageWithNameExistsExpectCheckNameIsTrue()
    {

        $user = UserModel::find(10);

        $date = Carbon::now();

        $version = ReleaseVersionModelMongo::get()->max('version');

        $page = PageModelMongo::where('parent_id', '!=', '0')->first();

        $request = $this->actingAs($user)
        ->post('api/pages', [
            'name' => $page->name,
            'version' => $version,
            'parent_id' => $page->parent_id,
            'due_date' => $date,
            'description' => 'Test case'
        ]);
        
        $request->seeJson([
            'checkName' => 1
        ]); 
    }
}