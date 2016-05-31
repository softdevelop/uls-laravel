<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Mongo\TermsModel;
use App\Models\Mongo\ManageTermModelMongo;
use App\Services\ManageTermService;
use Rowboat\FormBuilder\Models\Mongo\FieldMongo;
use App\Models\Mongo\TermTemplateManagerMongo;
use App\Services\UserService;
use App\Services\TermService;
class ManageTermController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* Init service to call function in it */
        $termSerive = new ManageTermService;

        /* Init term model to call function in it */
        $manageTernModel = new ManageTermModelMongo;

        /* Call function to set collection and fillable */
        $termName = $manageTernModel->setCollection($id);

        /* Get data */
        $items = $manageTernModel->get();

        /* Set termId */
        $termId = $id;

        /* Fields Name of term */
        $fields = $termSerive->getfieldNamesOfTerm($id);

        $fieldsName = [];
        foreach ($fields as $key => $value) {

            if(!in_array($value['element'], ['term','textarea', 'file'])){

                $fieldsName[] = $value;
            }
        }

        // d($fieldsName);die;

        return view('manage-term.index', compact('items', 'fieldsName', 'termName', 'termId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = TermsModel::find($termId);

        $htmlOrverideFiled = $term->viewForm();

        $field = FieldMongo::lists('name', '_id');

        $termName = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '_', $term->name));

        return view('manage-term.create', compact('term', 'field', 'htmlOrverideFiled', 'termName', 'termId'));
    }
    /**
     * [createNewItem description]
     * @param  [type] $termId [description]
     * @return [type]         [description]
     */
    public function createNewItem($termId)
    {
        $userService = new UserService();

        $term = TermsModel::find($termId);

        $user = \Auth::user();

        $htmlOrverideFiled = $term->viewForm();
        // d($htmlOrverideFiled);die;
        $user = \Auth::user();

        $tagHtml = TermService::tagHtml($term, $user);

        $field = FieldMongo::lists('name','_id');

        /* Set Item */
        $item = new ManageTermModelMongo();

        /* Set term name */
        $termName = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '_', $term->name));

        return view('manage-term.create', compact('term', 'field', 'htmlOrverideFiled', 'termName', 'termId', 'item','tagHtml'));
    }
    /**
     * [editItem description]
     * @param  [type] $termId [description]
     * @return [type]         [description]
     */
    public function editItem($termId, $id)
    {

        $userService = new UserService();

        $user = \Auth::user();
        
        $term = TermsModel::find($termId);

        /* Show html view term */
        $htmlOrverideFiled = $term->viewForm();

        /* lists fields */
        $field = FieldMongo::lists('name', '_id');

        /* Init term model to call function in it */
        $manageTernModel = new ManageTermModelMongo();

        /* Call function to set collection and fillable */
        $termName = $manageTernModel->setCollection($termId);

        /* Get data item */
        $item = $manageTernModel->find($id);

        $user = \Auth::user();
        
        $tagHtml = TermService::tagHtml($term, $user);
        /* Set term name */
        $termName = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '_', $term->name));

        return view('manage-term.edit', compact('term', 'field', 'htmlOrverideFiled', 'termName', 'termId', 'item','tagHtml'));
    }

    public function showDetail($termId,$id)
    {

        $data = ManageTermService::showDetailContent($termId,$id);

        return view('termTemplateManager.views.detail',compact('data'));
    }

    public function createModal($lenght)
    {   
        return view('manage-term.view-modal', compact('lenght'));
    }

}
