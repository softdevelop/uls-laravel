<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\RegionModel;
use App\Models\LanguageModel;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegionFormRequest;

class RegionsController extends Controller {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RegionFormRequest $request)
	 {
		$data = $request -> all();

		$region = new RegionModel;
		$region = $region -> CreateRegion($data);
		return new JsonResponse(['status' => 1, 'region' => $region]);
	 }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RegionFormRequest $request, $id)
	{
		$data = $request -> all();
		$region = RegionModel::find($id);

		if(!empty($region)) {
			$region = $region->EditRegion($data);
			return new JsonResponse(['status' => 1, 'region' => $region]);
		}

		return new JsonResponse(['status' => 0,'errors' => [['Error']], 'region' => (new RegionModel)]);
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
		$region = RegionModel::find($id);
		if(!empty($region)) {
			$region->delete();
			$status = 1;
		}
		return new JsonResponse(['status'=>$status]);
	}

}
