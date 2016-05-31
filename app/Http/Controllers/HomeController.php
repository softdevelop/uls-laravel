<?php namespace App\Http\Controllers;

use App\Models\Mongo\Notification;
use App\Models\TicketModel;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	public function uploadFile() 
	{
		$path = 'assets/css/bower_components/bootstrap-sass/assets/fonts/bootstrap/';

		$s3 = \Storage::disk('s3');

		$font = \Storage::disk('font');

		$files = $font->files();

		foreach ($files as $key => $value) {
			// dd($path.$value);
			$s3->put($path.$value, $font->get($value));
		}
		die('done');
		
	}

}
