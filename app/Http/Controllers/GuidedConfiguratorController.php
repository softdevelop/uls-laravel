<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GuidedConfiguratorController extends Controller {


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

		return view('guide.guided-configurator');

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function showGuide()
	{

		return view('guide.view.guide-me');

	}

}
