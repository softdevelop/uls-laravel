<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagesModel;
use Illuminate\Http\JsonResponse;
use App\Models\Mongo\SeoModelMongo;
use PHPHtmlParser\Dom;
use App\Services\TrafficService;
use App\Models\Mongo\TrafficModelMongo;
use App\Services\PagesSeoService;
use App\Models\PagesSeoModel;

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

	 /**
	  * get list pages sync
	  * @return [type] [description]
	  */
	public function getIndex()
	{
		/* Get all page for show in pages tree */
	 	$pagesTree = PagesSeoService::getPagesTree();
	 	
	 	return view('pages-sync.index', compact('pagesTree'));
	}

	/**
	*getSeoPageReport
	* @return [type] [description]
	*/
	public function getSeoPageReport($pageId, $state = 'overview')
	{

		// $trafficModelMongo = new TrafficModelMongo();

		//   $traffic = $trafficModelMongo->getTraffic(9);
		//   $array = array_where($traffic->toArray(), function($key, $value)
		//   {
		//       return $value['rows'][14] == '2015-09-26';
		// }  );

		//   $total = array_fetch($array, 'rows.12');
		//   d(array_sum($total));die;


		$trafficModelMongo = new TrafficModelMongo();
		$results = $trafficModelMongo->getTraffic($pageId);
	 	$seoModelMongo = new SeoModelMongo();
	 	$seoData = $seoModelMongo->getSeoPageReport($pageId);
	 	$pageObject = PagesModel::find($pageId);

	 	return view('pages-sync.view', compact('seoData', 'results', 'state', 'pageId', 'pageObject'));
	}

	public function getLinks()
	{
		$pagesSyncModel = new PagesSyncModel();
		$pagesSyncModel->synPages('http://www.ulsinc.com');
		die;
	}

	/**
	 * getTraffoc
	 * @return [type] [description]
	 */
	public function getTraffic()
	{
		$pagesAll = PagesSeoModel::where('parent_id', '!=', 0)->get();

		$startDate = '2015-09-24';
		$endDate = '2015-09-30';

		$trafficModelMongo = new TrafficModelMongo;
		foreach ($pagesAll as $key => $value) {
			$url =  str_replace("http://www.ulsinc.com/", "~/",  $value->url);
			$trafficModelMongo->saveTrafficWithUrl($startDate, $endDate,$value->id, $url);
		}
		
		die('done');
	}

	/**
	 * getTraffoc
	 * @return [type] [description]
	 */
	public function trafficPage()
	{
		$trafficModelMongo = new TrafficModelMongo();
		$results = $trafficModelMongo->getTraffic(237);
		
		return view('pages-sync.page-traffic', compact('results'));
	}  

}
