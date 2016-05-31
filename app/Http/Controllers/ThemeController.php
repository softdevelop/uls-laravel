<?php namespace App\Http\Controllers;

use App\Services\FindRepresentatives\FindByAddressService;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Rowboat\ContentManagement\Events\Pages\BeforePageReview;
use Rowboat\ContentManagement\Models\Mongo\ContentModelMongo;
use Rowboat\DatabaseManagement\Services\GuidedConfiguratorService;
use Rowboat\DatabaseManagement\Services\ConfiguratorService;
use Rowboat\DatabaseManagement\Models\Mongo\ConfiguratorMongo;

class ThemeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Theme Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

    public function __construct()
    {

        $this->middleware('auth');
    }
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */	
	public function getTable()
	{
		return view('theme.table');
	}
	public function getGeneralelement()
	{
		return view('theme.generalelement');
	}
	public function getReleaseversion()
	{
		return view('theme.release-version');
	}

	public function getConfigurator()
	{
			
	}

}
