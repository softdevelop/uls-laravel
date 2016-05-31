<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mongo\TermsModel;
use Rowboat\FormBuilder\Models\Mongo\FieldMongo;
use App\Services\UserService;
use App\Services\TermService;

class TermController extends Controller {


    public function __construct()
    {

        $this->middleware('auth');
    }
    /**
     * show list users (used by admin)
     * @return ViewObject
     */
    public function getIndex()
    {
        if(\Auth::user()->can('user_admin')) {
            $termModel = new TermsModel();

            $terms = $termModel->getTerms();

            return view('terms.index',compact('terms'));
        }
        return redirect('/');
    }

    public function getCreate()
    {

        return view('terms.create');
    }

    public function getShow($id)
    { 

        $userService = new UserService();

        $term = TermsModel::find($id);
        if (empty($term)) {
            abort(404);
        }
        $user = \Auth::user();

        $htmlOrverideFiled = $term->viewForm();
        // d($htmlOrverideFiled);die;
        $user = \Auth::user();
        
        $tagHtml = TermService::tagHtml($term, $user);

        $field = FieldMongo::lists('name','_id');
        
        return view('terms.test',compact('term', 'field', 'htmlOrverideFiled','tagHtml'));

    }
    
    public function getEdit($id)
    {
        $userService = new UserService();

        $term = TermsModel::find($id);      
        if (empty($term)) {
            abort(404);
        }
        $htmlOrverideFiled = $term->viewHtmlFieldInCurrentTerm();
        // $isMulti = $data['isMulti'];
        
        $user = \Auth::user();

        $tagHtml = TermService::tagHtml($term, $user);
        $field = FieldMongo::lists('name','_id');

        return view('terms.edit',compact('term', 'field', 'htmlOrverideFiled','tagHtml'));
    }

    public function getUpdateHtmlField($id,$idField)
    {
        $term = TermsModel::find($id);
        if (empty($term)) {
            abort(404);
        }
        $orveride = $term->viewOrverideField($idField);

        return view('terms.update-html-field',compact('orveride'));
    }

    public function getAddWrapper($id,$idField)
    {
        return view('terms.add-wrapper');
    }

}
