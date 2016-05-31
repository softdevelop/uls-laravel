<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Rowboat\Users\Models\UserModel;
use App\Models\Mongo\TermsModel;
use Rowboat\FormBuilder\Models\Mongo\FieldMongo;
use App\Models\Mongo\TermTemplateManagerMongo;
use Rowboat\FormBuilder\Models\Mongo\FiledTypeMongo;

class TermTemplateManagerController extends Controller
{
    

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
    public function index($termId)
    {
        $templates = TermTemplateManagerMongo::where('termId',$termId)->get();
        $templateType = TermTemplateManagerMongo::$templateType;

        return view ('termTemplateManager.index',compact('templates','templateType','termId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($termId)
    {
        $id = $termId;

        $userFillable = [];

        $userModel = new UserModel();

        foreach ($userModel['fillable'] as $key => $value) {
            
            if($value != 'password'){

                $userFillable[$key]['name'] = strtolower(str_replace("_"," ",$value));

                $userFillable[$key]['key'] = 'user.'.$value;                
            }
        }

        $term =TermsModel::find($termId);

        $fields = [];

        $termName = str_replace(" ","_", $term->name);

        foreach ($term->fields as $index => $item) {

            $field = FieldMongo::find($item['field_id']);

            $filedType = FiledTypeMongo::find($field->field_type_id);

            if(!empty($filedType)){

                if($field->fieldType->output_type === 'term'){

                    $field['name'] = TermsModel::find($filedType->termId)->ngModel;

                }
            }

            $fields[$index] = $item;

            $fields[$index]['name'] = $field['name'];

            $fields[$index]['alias'] = strtolower($termName . '.' . str_replace(" ", "_", $field['name']));
        }

        $term->fields = $fields;

        return view('termTemplateManager.create')->with('termId',$id)->with('template', new TermTemplateManagerMongo())->with('userFillable',$userFillable)->with('term',$term);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($termId,$id)
    {
        $template = TermTemplateManagerMongo::find($id);

        $userFillable = [];

        $userModel = new UserModel();

        foreach ($userModel['fillable'] as $key => $value) {

            if($value != 'password'){

                $userFillable[$key]['name'] = strtolower(str_replace("_"," ",$value));

                $userFillable[$key]['key'] = 'user.'.$value;
            }
        }

        $term =TermsModel::find($termId);

        $fields = [];

        $termName = str_replace(" ","_", $term->name);

        foreach ($term->fields as $index => $item) {

            $field = FieldMongo::find($item['field_id']);

            $filedType = FiledTypeMongo::find($field->field_type_id);

            if(!empty($filedType)){

                if($field->fieldType->output_type === 'term'){

                    $field['name'] = TermsModel::find($filedType->termId)->name;

                }
            }

            $fields[$index] = $item;

            $fields[$index]['name'] = $field['name'];

            $fields[$index]['alias'] = strtolower($termName . '.' . str_replace(" ", "_", $field['name']));
        }

        $term->fields = $fields;

        return view('termTemplateManager.create', compact('termId', 'template', 'userFillable', 'term'));
    }

    /**
     * View image of template
     * @param  string $path [description]
     * @return [type]       [description]
     */
    public function viewImage($path)
    {
        // return view('templatemanager.viewImage',compact('path'));
    }
    

}
