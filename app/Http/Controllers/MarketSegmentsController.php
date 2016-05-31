<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MarketSegmentModel;

class MarketSegmentsController extends Controller {
	

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
		$marketSegments = MarketSegmentModel::get();
		return view('marketsegments.index', compact('marketSegments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$marketSegment = new MarketSegmentModel;
		return view('marketsegments.create', compact('marketSegment'));
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
		$marketSegment = MarketSegmentModel::find($id);
		return view('marketsegments.create', compact('marketSegment'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	

}
