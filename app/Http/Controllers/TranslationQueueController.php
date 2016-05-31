<?php namespace App\Http\Controllers;

use DateTime;
use App\Http\Requests;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\TranslationQueueModel;
use App\Models\PageModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class TranslationQueueController extends Controller {


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
		$translations = TranslationQueueModel::all();
		$timeNow = new DateTime();
		foreach ($translations as $key => $value) {
			$updated_at = new DateTime($value['updated_at']);
			$dateDiff = ($timeNow->diff($updated_at));
			$dateDiff->format('%d days');
			$value['last_updated'] = $dateDiff->d;
			$value->page;
			$value->parent_name = $value->page->name;
			$value->language;
		}		
		return view('translation-queue.index', compact('translations'));
	}

	public function show()
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
		$translation_queue = new TranslationQueueModel;
		$translation = $translation_queue->getTranslationById($id);

		$pageModel = new PageModel;

		$translation->page;
		$translation->language;

		return view('translation-queue.editor', compact('translation'));
	}

}
