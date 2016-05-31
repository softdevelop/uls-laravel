<?php namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
class FileFormRequest extends FormRequest{
	public function rules(){ 
		return [
			// 'file'=>'required',
			// 'role_id'=>'required'
		];
	}

	public function authorize(){
		return true;
	}

	/**
	 * Get the proper failed validation response for the request.
	 *
	 * @param  array  $errors
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function response(array $errors)
	{
		
		return new JsonResponse(['status'=>0, 'error'=>$errors], 422);
	}
}