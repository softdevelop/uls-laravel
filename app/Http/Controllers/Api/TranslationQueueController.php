<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\TranslationQueueModel;
use App\Services\TranslationQueueService;
use Illuminate\Http\Request;

class TranslationQueueController extends Controller {
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id )
	{
		$data = $request->all();
		$TranslationQueueModel = new TranslationQueueModel;
		$result = $TranslationQueueModel -> editTranslation ($data, $id);

		return new JsonResponse($result);
	}

	/**
	 * upload a file excel
	 * @param  Request $request [description]
	 * @return JsonResponse
	 */
	public function upload(Request $request)
	{
		$file = $request -> file('file');

		$translationService = new TranslationQueueService;
		$result = $translationService -> uploadExcel ($file);
		return new JsonResponse($result);
	}

	/**
	 * export data to excel file
	 * @param  Request $request [data]
	 * @return [xls]           [file export]
	 */
	public function export(Request $request)
	{
		$data = $request -> all();
		$translationService = new TranslationQueueService;
		$translationService -> exportExcel ($data);
	}
}
