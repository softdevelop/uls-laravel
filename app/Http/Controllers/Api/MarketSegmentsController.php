<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\MarketSegmentModel;
use App\Http\Requests\MarketSegmentFormRequest;

class MarketSegmentsController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MarketSegmentFormRequest $request)
	{
		$data = $request->all();
		$marketSegment = new MarketSegmentModel;
		$result = $marketSegment->createNewMarketSegment($data);

		return new JsonResponse($result);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, MarketSegmentFormRequest $request)
	{
		$data = $request->all();
		$marketSegment = new MarketSegmentModel;
		$result = $marketSegment->updatemarketSegmentById($id, $data);
		
		return new JsonResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
