<?php namespace App\Services;

use Rowboat\FormBuilder\Models\Mongo\FieldMongo;
use Rowboat\FormBuilder\Models\Mongo\FiledTypeMongo;
use App\Models\Mongo\TermsModel;
use App\Models\Mongo\ManageTermModelMongo;
use App\Models\Mongo\TermTemplateManagerMongo;
use App\Services\UserService;

class ManageTermService
{
    /**
     * [getfieldNamesOfTerm description]
     * @param  int $id id of term
     * @return array     array name fields of term
     */
	public static function getfieldNamesOfTerm($key)
    {
        /* Find term with id input */
        $term = TermsModel::find($key);

        if(empty($term)){

            $term = TermsModel::where('ngModel', $key)->first();
        }
        /* Get fields of term */
        $fieldsTerm = $term->fields->toArray();

        /* Init array to contain field name */
        $fieldNames = [];

        /* Get all name of field in term */
        foreach ($fieldsTerm as $key => $value) {

            $field = FieldMongo::find($value['field_id']);

            $filedType = FiledTypeMongo::find($field->field_type_id);

            if(!empty($filedType)){

                $element =  $field->fieldType->output_type;

                if($element === 'term'){

                    $field->name = TermsModel::find($filedType->termId)->ngModel;

                }
                
            }else{

                $element = $field->field_type_id;
            }

            $fieldNames[$key] = [
                'title' => $field->name,
                'name'  =>  str_replace(' ', '_', strtolower($field->name)),
                'element' => $element
            ];
        }

        return $fieldNames;
    }

    public static function showDetailContent($termId, $id)
    {
        $manageTernModel = new ManageTermModelMongo();

        $termName = strtolower($manageTernModel->setCollection($termId));

        $termAlias = str_replace(' ','_', strtolower($termName));

        $template = new TermTemplateManagerMongo();

        $template = $template->where('termId',$termId)->where('type','detail')->first();
        
        $content = '';

        if(!empty($template)){

            $content = str_replace('\/','/',$template->html);

            $userService = new UserService();

            //get data of content type
            $dataOfContent = $manageTernModel->where('_id', $id)->first();

            $fields = self::getfieldNamesOfTerm($termId);

            $isUser = false;
            // d($fields);die;
            foreach ($fields as $index => $item) {

                foreach ($dataOfContent->toArray() as $key => $value) {

                    if($key === 'user_id' && !$isUser){

                        $content = $userService->getInforUser($content, $value);

                        $isUser = true;

                        // break;
                    }

                    if($item['name']  == str_replace(' ','_', strtolower($key))){

                        switch ($item['element']) {
                            case 'select':
                                if(!empty(getDataOptionsMap()[$value]))
                                    $content = str_replace('{{' . $termAlias . '.' . $key . '}}', getDataOptionsMap()[$value]['name'], $content);
                                break;
                            case 'date':
                                    $content = str_replace('{{' . $termAlias . '.' . $key . '}}', date('m-d-Y',strtotime($value)), $content);
                                break;
                            case 'number':
                                    $content = str_replace('{{' . $termAlias . '.' . $key . '}}', number_format($value), $content);
                                break;
                            case 'term':

                                    $fieldsTermChildren = self::getfieldNamesOfTerm($item['name']);

                                    $data = [
                                        'term' => $value,
                                        'fields' => $fieldsTermChildren
                                    ];

                                    $view = view('termTemplateManager.views.term-children', $data)->render();
                                
                                    $content = str_replace('{{' . $termAlias . '.' . $key . '}}', $view, $content);

                                break;
                            case 'file':

                                    $data = [
                                        'files' => $value,
                                    ];
                                    // d(fileManagerTermMap());die;
                                    $view = view('termTemplateManager.views.show-files', $data)->render();
                                    
                                    $content = str_replace('{{' . $termAlias . '.' . $key . '}}', $view, $content);
                                break;
                            default:
                                if(!is_array($value))
                                    $content = str_replace('{{'. $termAlias . '.' . $key . '}}', $value, $content);
                                break;
                        }
                    }

                }

            }

        }else{
            $content = '<h1>Not Template</h1>';
        }


        return ['content' => $content, 'name' => $termName];        
    }

}