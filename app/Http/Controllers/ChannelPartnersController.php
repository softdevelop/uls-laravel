<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ChannelPartnersModel;
use App\Models\RegionModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChannelPartnersController extends Controller {


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
		$partners  = ChannelPartnersModel::get();
		foreach ($partners as $key => $value) {
			$value->region;
		}
		return view('channelpartners.index') -> with('partners',$partners);
	}

	public function show()
	{
		abort(404);
	}
 	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$countries = RegionModel::get();
		return view('channelpartners.create',array('partner' => new ChannelPartnersModel(),
													'countries' => $countries
											));
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$countries = RegionModel::get();
		$partner = ChannelPartnersModel::find($id);
		
		if($partner->suite == 'null') {
			$partner->suite = '';
		}
		return view ('channelpartners.create', compact('partner','countries'));
	}

}
