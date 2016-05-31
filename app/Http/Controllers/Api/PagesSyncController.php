<?php 
namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagesSyncModel;
use Illuminate\Http\JsonResponse;
use App\Models\Mongo\SeoModelMongo;
use App\Models\PagesSeoModel;
use App\Services\PagesSeoService;
class PagesSyncController extends Controller {
	
	/**
	  * Create a new controller instance.
	  *
	  * @return void
	  */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function showSeoReportPage($pageId)
	{
        $seoData = PagesSeoService::getChildPagesById($pageId);
        
	 	return new JsonResponse(['item'=>$seoData]);
	}
	/**
	 * [get html sync Pages with url ='http://www.ulsinc.com/site-map' and save db]
	 * @return [type] [description]
	 */
	public function synPageReport()
	{
		// Create a new Pages Seo Service.
		$PagesSeoService = new PagesSeoService();
		// Create a new Seo Model Mongo.
		$SeoModelMongo = new SeoModelMongo();
		// Create a new Pages Seo Model.
		$PagesSeoModel = new PagesSeoModel();
		//creating a data array on from the get html with url ='http://www.ulsinc.com/site-map'
		$synPages = $PagesSeoService->parseHtmlFromUrl('http://www.ulsinc.com/site-map');
		//save the new bage db segment has been purged of the old site
		$saveSynPages = $PagesSeoModel->saveSynPages($synPages);
		//100 pages in Mongo update include new pages and pages but over 30 days
		$saveMongoSeo = $PagesSeoService->saveMongoSeo();
		//get all page form db
		$pages = PagesSeoService::getPagesTree();

		return new JsonResponse(['pages'=>$pages]);

	}


}
