<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CampaignManagerModel;

use Illuminate\Http\Request;

class CampaignManagerController extends Controller {


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
		if(\Auth::user()->can('user_admin')) {
			$campaignss = CampaignManagerModel::get();
			return view('campaignsmanager.index', compact('campaignss'));
        }
        return redirect('/');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$campaign = new CampaignManagerModel;
		return view('campaignsmanager.create', compact('campaign'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
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
		$campaign = CampaignManagerModel::find($id);
		return view('campaignsmanager.create', compact('campaign'));
	}

}
