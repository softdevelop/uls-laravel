<?php 
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\PageModel;

class FolderFormRequest extends FormRequest{
	
	public function rules()
    {
        $data  = $this->all();
        $rules = [
			'folder_name' => 'required|unique:pages,name,null,id,parent_id,0,name,'.$data['folder_name']
		];
        return $rules;
    }

	public function authorize()
	{
		return true;
	}

	public function messages()
    {
        return [
            'folder_name.unique' => 'The name has already been taken.'
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