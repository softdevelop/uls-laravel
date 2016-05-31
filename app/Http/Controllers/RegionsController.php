<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FormRegionRequest;
use App\Models\RegionModel;
use App\Models\LanguageModel;
use Illuminate\Http\JsonResponse;


class RegionsController extends Controller {

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$regions = RegionModel::get();
		for($i = 0; $i < count($regions); $i++) {
			$regions[$i]['languages'] = $regions[$i]->languages;
		}
		$LanguageModel = new LanguageModel;
		$languages_list = $LanguageModel -> getListActiveLanguages();
		return view('regions.index') -> with('regions', $regions)
									 -> with('languages_list',$languages_list);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$LanguageModel = new LanguageModel;
		$languages = $LanguageModel -> getActiveLanguages();
		return view('regions.create', array('region' => new RegionModel(), 'languages' => $languages));
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($name)
	{
		abort(404);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$LanguageModel = new LanguageModel;
		$languages = $LanguageModel -> getActiveLanguages();
		$region = RegionModel::find($id);
		$temps = [];
		$region_languages = $region->languages()->get();
		for($i = 0; $i < count($region_languages); $i++) {
			array_push($temps,$region_languages[$i]->id);
		}
		$region['languages'] = $temps;
		return view('regions.create', compact('region', 'languages'));
	}

}
