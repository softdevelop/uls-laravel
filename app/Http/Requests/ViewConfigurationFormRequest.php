<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class ViewConfigurationFormRequest extends Request
{
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
         return [
            'FName' => 'required',
            'LName' => 'required',
            'EmailAddr' => 'required',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'FName.required' => 'The First Name field is required.',
            'LName.required'  => 'The Last Name field is required.',
            'EmailAddr.required'  => 'The Email Address field is required.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        // d($validator->errors()->getMessages());die;
        return $validator->errors()->getMessages();
    }
}
