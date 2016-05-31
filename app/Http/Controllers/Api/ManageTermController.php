<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Mongo\ManageTermModelMongo;
use Illuminate\Http\JsonResponse;
use Rowboat\FormBuilder\Models\FileFormBuilderModel;

class ManageTermController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Get all data input */
        $data = $request->all();

        // d($data);die;

        /* Init term model to call function in it */
        $manageTernModel = new ManageTermModelMongo;

        /* Call function to set collection and fillable */
        $termName = $manageTernModel->setCollection($data['termId']);

        /* Call function to create new data */
        $result = $manageTernModel->saveData($data, \Auth::user());

        return new JsonResponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* Get all data input */
        $data = $request->all();

        /* Init term model to call function in it */
        $manageTernModel = new ManageTermModelMongo;

        /* Call function to update data */
        $item = $manageTernModel->updateData($id, $data, $data['termId']);

        return new JsonResponse($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /* Set term Id from Input */
        $termId = \Input::get('termId');

        /* Init term model to call function in it */
        $manageTernModel = new ManageTermModelMongo;

        /* Call function to set collection and fillable */
        $termName = $manageTernModel->setCollection($termId);

        $status = \DB::connection('mongodb')->table($manageTernModel->getTable())->where('_id', $id)->delete();

        return empty($status)?
            ['status'=>0, 'message'=>'item not found'] : 
            ['status'=>1, 'message'=>'delete item success'];
    }

    public function getFileManagerTerm()
    {
        $fileModel = new FileFormBuilderModel();

        $files = $fileModel->getFilesManagerTerm();

        return $files;
    }
}
