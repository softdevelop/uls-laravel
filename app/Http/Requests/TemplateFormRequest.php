<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use App\Models\TemplateManagerModel;

class TemplateFormRequest extends FormRequest
{
    protected $rules = [
        'title'=>'required',
        'alias_title'=>'unique:templates,alias_title',
        'description'=>'required'
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;
        $data = $this->all();
        if (!empty($data['id']))
        {
            $template = TemplateManagerModel::find($data['id']);

            if($template->alias_title == $data['alias_title']) {
                $rules = [
                    'title'=>'required',
                    'description'=>'required'
                 ]; 
            } 
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'alias_title.unique' => 'The name has already been taken'
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse(['status'=>0, 'errors'=>$errors]);
    }
}
