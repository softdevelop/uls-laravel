<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FindRepresentatives\FindByAddressService;
use Rowboat\CmsContent\Services\ParserContentService;
use Rowboat\ContentManagement\Services\PagesService;

class FindRepByAddressController extends Controller {


    public function __construct()
    {

        $this->middleware('auth');
    }
    /**
     * show list users (used by admin)
     * @return ViewObject
     */
    public function getFindRepresentatives()
    {

        return view('find-representatives.index');
    }

    public function postFindByAddress(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $address = $request->get('address');

            $findByAddressService = new FindByAddressService();

            if(!empty($address)){

                $results = 'test';

                $geocode = $findByAddressService->getGeocode($address);
                
                $results = $findByAddressService->getChannelPartners($geocode);

            }else{

                $results = [];

            }
            $parserContentService = new ParserContentService();
            $pathContent = base_path('resources/views/find-representatives/view-search-result.blade.php');

            $contentTemplate = PagesService::getContentHeaderView($pathContent);
            // parser content template to render view
            $contentTemplate = $parserContentService->parserContentReView($contentTemplate, null, null);
            // dd($contentTemplate);

            \Storage::disk('views')->put('templates/view-search-representative.blade.php' , $contentTemplate); 
            return view('templates.view-search-representative',  
                array('results' => $results, 
                      'address' => $address,
                      '_56be0c11d64791fe6f8b45a4_field_title' => 'Find a Representative',
                      '_56be0c11d64791fe6f8b45a4_field_metakeywords' => 'Find a Representative',
                      '_56be0c11d64791fe6f8b45a4_field_metadescription' => 'Find a Representative'
                     ))->render();        
            // return view('find-representatives.view-search-result', array('results' => $results, 'address' => $address));
        }else{
            return view('find-representatives.index');
        }
    }

}
