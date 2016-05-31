<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\RegionModelMongo;
use App\Models\LanguageModel;
use App\Http\Requests\LanguageFormRequest;

class LanguagesController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LanguageFormRequest $request)
	{
		$data 	  = $request->all();
		$language = new LanguageModel;
		$result   = $language->createNewLanguage($data);

		return new JsonResponse($result);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, LanguageFormRequest $request)
	{
		$data 	  = $request->all();
		$language = new LanguageModel;
		$result   = $language->updateLanguageById($id, $data);
		
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
		$language = LanguageModel::find($id);
		$status   = 0;

		if(!empty($language)){

			$status = $language->delete();
		}

		return empty($status)?
			['status'=>0, 'message'=>'language not found'] : 
			['status'=>1, 'message'=>'delete language success'];
	}
}
