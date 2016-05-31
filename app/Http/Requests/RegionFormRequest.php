<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\RegionModel;

class RegionFormRequest extends FormRequest
{
    protected $rules = [
        'name'=>'required',
        'alias_name'=>'unique:regions,alias_name',
        'code'=>'required|unique:regions,code',
        'active'=>'required',
        'languages' =>'required'
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
            $region = RegionModel::find($data['id']);

            if($region->alias_name == $data['alias_name'] && $region->code == $data['code']) {
                $rules = [
                    'name'=>'required',
                    'code'=>'required',
                    'active'=>'required',
                    'languages' =>'required'
                 ]; 
            } else if($region->alias_name == $data['alias_name'] && $region->code != $data['code']) {
                $rules = [
                    'code'=>'required|unique:regions,code'
                ];
            } else if($region->code == $data['code'] && $region->alias_name != $data['alias_name']){
                $rules = [
                    'alias_name'=>'required|unique:regions,alias_name'
                ];
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'alias_name.unique' => 'The name has already been taken.'
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse(['status'=>0, 'errors'=>$errors]);
    }
}
