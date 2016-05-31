<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Rowboat\AssetsManagement\Models\Mongo\AssetsFileModelMongo;


class TestController extends Controller {
	
	/**
	  * Create a new controller instance.
	  *
	  * @return void
	  */
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
	 	
	 	return view('test');
	}

	public function getTags(Request $request)
	{
		$data = $request->all();
		
		$dataValue = array_values($data);

		$assetFile = AssetsFileModelMongo::whereIn('tags', $dataValue)->get();
		
		return $assetFile;

	}

}
