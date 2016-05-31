<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mongo\TermsModel;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use App\Services\TermService;

class TermController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $data=$request->all();
        $termModel = new TermsModel;
        $beenTaken =$termModel->where('name',$data['name'])->count();
        if($beenTaken!=0){
            return new JsonResponse(['status'=>0, 'error'=>'The term name has already been taken.']);
        }
        $term = $termModel->store($data);

        return new JsonResponse(['status' =>1, 'term' => $term]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $data=$request->all();
        $termsModels = new TermsModel;
        $beenTaken =$termsModels->where('_id','<>',$id)->where('name',$data['name'])->count();
        if($beenTaken!=0){
            $termModel = $termsModels->find($id);
            return new JsonResponse(['status'=>0, 'error'=>'The field name has already been taken.','name'=>$termModel['name']]);
        }
        $termModel = $termsModels->find($id);
        $term = $termModel->updateTerm($data);

        return new JsonResponse(['status' => 1,'term' => $term]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateTerm($id,$_id, Request $request)
    {
        $data=$request->all();
        $termsModels = new TermsModel;
        $beenTaken =$termsModels->where('_id','<>',$id)->where('name',$data['name'])->count();
        if($beenTaken!=0){
            $termModel = $termsModels->find($id);
            return new JsonResponse(['status'=>0, 'error'=>'The field name has already been taken.','name'=>$termModel['name']]);
        }
        $termModel = $termsModels->find($id);
        $term = $termModel->updateTerm($data);

        return new JsonResponse(['status' => 1,'term' => $term]);
    }


    public function deleteFieldTerm($id, $_id)
    {
        $status = 0;

        $userService = new UserService();

        $user = \Auth::user();

        $term = TermsModel::find($id);

        if(empty($term)){

            abort('Not Found');
        }

        $data = $term->deleteFieldTerm($_id);

        $status = $data['status'];

        $htmlOrverideFiled = $term->viewHtmlFieldInCurrentTerm();
        $user = \Auth::user();
        $tagHtml = TermService::tagHtml($term, $user);
        return new JsonResponse(['status' => $status, 'htmlOrverideFiled' => $htmlOrverideFiled, 'tagHtml' => $tagHtml]);
    }
    public function deleteGroupHtml(Request $request)
    {
        $user = \Auth::user();

        $data = $request->all()['id'];
        $term = TermsModel::find($data['id']);

        $status = $term->deleteWrapper($data);
        $fields= $term->viewHtmlFieldInCurrentTerm();
        $user = \Auth::user();
        $tagHtml = TermService::tagHtml($term, $user);
        return new JsonResponse(['status' => $status,'fields' => $fields,'tagHtml'=>$tagHtml]);

    }
    public function showHtmlField($id, Request $request)
    {

        $userService = new UserService();

        $term = TermsModel::find($id);

        $user = \Auth::user();

        $data = $term->showHtmlField($request->all());

        $user = \Auth::user();

        $htmlOrverideFiled= $term->viewHtmlFieldInCurrentTerm();

        $tagHtml = TermService::tagHtml($term, $user);
        return new JsonResponse(['item' => $data,'htmlOrverideFiled'=> $htmlOrverideFiled,'tagHtml'=>$tagHtml]);
    }

    public function updateHtmlField($id, Request $request)
    {

        $term = TermsModel::find($id);

        $term->orverideFieldTerm($request->all());
        $htmlOrverideFiled = $term->viewHtmlFieldInCurrentTerm();

        $user = \Auth::user();

        $tagHtml = TermService::tagHtml($term,$user);
        return new JsonResponse(['tagHtml' => $tagHtml,'htmlOrverideFiled '=>$htmlOrverideFiled ]);
    }

    public function addWrapper($id, $_id, Request $request)
    {
        $data = $request->all();

        $dataHTML = [];

        $term = TermsModel::find($id);

        $status = $term->addWrapper($_id, $data);

        $user = \Auth::user();

        $fields = $term->viewHtmlFieldInCurrentTerm();

        $tagHtml = TermService::tagHtml($term, $user);

        return new JsonResponse(['status' => $status,'fields' => $fields,'tagHtml'=>$tagHtml]);
    }

    /**
     * [changeFieldIsModal description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function changeFieldIsModal(Request $request)
    {
        /* Get all date input */
        $data = $request->all();

        /* Find term with data input */
        $term = new TermsModel;

        /* Call function change field of term is modal */
        $item = $term->changeFieldIsModal($data);

        return new JsonResponse(['item' => $item]);
    }

    /**
     * Delete Term
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  String $id [description]
     *
     * @return Json     [description]
     */
    public function destroy($id)
    {
        $term = TermsModel::find($id);

        $status   = 0;

        if(!empty($term)){

            $status = $term->delete();
        }

        return new JsonResponse(['status' => $status]);
    }
}
