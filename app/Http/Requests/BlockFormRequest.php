<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use App\Models\BlockModel;

class BlockFormRequest extends FormRequest
{
    protected $rules = [
        'name'=>'required',
        'title'=>'required',
        'alias_name'=>'unique:blocks,alias_name',
        'body'=>'required'
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
            $block = BlockModel::find($data['id']);

            if($block->alias_name == $data['alias_name']) {
                $rules = [
                    'name'=>'required',
                    'title'=>'required',
                    'body'=>'required'
                 ]; 
            } 
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'alias_name.unique' => 'The name has already been taken'
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse(['status'=>0, 'errors'=>$errors]);
    }
}
