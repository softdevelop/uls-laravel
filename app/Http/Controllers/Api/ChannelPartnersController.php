<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelPartnerFormRequest;
use Illuminate\Http\JsonResponse;
use App\Models\ChannelPartnersModel;
use Illuminate\Http\Request;

class ChannelPartnersController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ChannelPartnerFormRequest $request)
	{
		$data = $request -> all();
		$partner = new ChannelPartnersModel;
		$partner = $partner -> createChannelPartner($data);
		$partner->region;
		return new JsonResponse(['status'=>1, 'partner' => $partner]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ChannelPartnerFormRequest $request, $id)
	{
		$data = $request -> all();
		$partner = ChannelPartnersModel::find($id);

		if(!empty($partner)) {
			$partner = $partner->editChannelPartner($data);
			$partner->region;
			return new JsonResponse(['status' => 1, 'partner' => $partner]);
		}
		return new JsonResponse(['status' => 0,'errors' => [['Error']], 'partner' => (new ChannelPartnersModel)]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$status = 0;
		$partner = ChannelPartnersModel::find($id);
		if(!empty($partner)) {
			$partner -> delete();
			$status = 1;
		}
		return new JsonResponse (['status'=>$status]);
	}

	/**
	 * Check a partner is unique
	 * @param  Request $request [request from form]
	 * @return [Json]           []
	 */
	public function checkPartner(Request $request) 
	{	
		$data = $request -> all();

		$ChannelPartnersModel = new ChannelPartnersModel;
		$result = $ChannelPartnersModel -> checkChannelPartner($data);

		return new JsonResponse($result);

	}

}
