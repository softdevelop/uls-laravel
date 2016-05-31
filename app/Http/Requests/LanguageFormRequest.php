<?php 
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\LanguageModel;

class LanguageFormRequest extends FormRequest{
	protected $rules = [
		'name'		 =>'required',
		'code'		 =>'required|unique:languages,code',
		'native_name'=>'required',
		'direction'	 =>'required',
		'active'	 =>'required',
		'alias_name' =>'unique:languages,alias_name'
	];

	public function rules()
    {
        $rules = $this->rules;
        $data  = $this->all();
        if (!empty($data['id'])){
        	$language = LanguageModel::find($data['id']);
        	if($language->alias_name == $data['alias_name'] && $language->code == $data['code']){
        		$rules = [
        			'code'		=>'required|unique:languages,code,null,id,code,!='.$language->code,
					'alias_name'=>'required|unique:languages,alias_name,null,id,alias_name,!='.$language->alias_name
				];
        	}else if($language->alias_name != $data['alias_name'] && $language->code == $data['code']) {
                $rules = [
                	'alias_name'=>'required|unique:languages,alias_name'
                ]; 
            }else if($language->alias_name == $data['alias_name'] && $language->code != $data['code']) {
                $rules = [
                	'code'=>'required|unique:languages,code'
                ];
            }  
        }
        return $rules;
    }

	public function authorize()
	{
		return true;
	}

	public function messages()
    {
        return [
            'alias_name.unique' => 'The name has already been taken.'
        ];
    }

	/**
	 * Get the proper failed validation response for the request.
	 *
	 * @param  array  $errors
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function response(array $errors)
	{
		return new JsonResponse(['status'=>0, 'error'=>$errors]);
	}
}