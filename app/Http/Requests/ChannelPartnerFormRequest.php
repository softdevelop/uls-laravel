<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\ChannelPartnersModel;

class ChannelPartnerFormRequest extends FormRequest
{
    protected $rules = [
        'name'=>'required',
        'address'=>'required',
        'city'=>'required',
        'zipcode'=>'required|numeric',
        'telephone'=>'required',
        'email'=>'required|unique:channel_partners,email',
        'region_id' => 'required',
        'alias_name'=>'unique:channel_partners,alias_name'
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
            $partner = ChannelPartnersModel::find($data['id']);

            if($partner->alias_name == $data['alias_name'] && $partner->email == $data['email']) {
                $rules = [
                    'name'=>'required',
                    'address'=>'required',
                    'city'=>'required',
                    'zipcode'=>'required|numeric',
                    'telephone'=>'required',
                    'email'=>'required',
                    'region_id' => 'required'
                 ]; 
            } else if($partner->alias_name == $data['alias_name'] && $partner->email != $data['email']) {
                $rules = [
                    'email'=>'required|unique:channel_partners,email'
                ];
            } else if($partner->email == $data['email'] && $partner->alias_name != $data['alias_name']){
                $rules = [
                    'alias_name'=>'required|unique:channel_partners,alias_name'
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
