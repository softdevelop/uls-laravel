<?php 
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\PageModel;

class PageFormRequest extends FormRequest{
	protected $rules = [
		'name'		 	=>'required',
		'url' 		 	=>'required|unique:pages,url'
	];

	public function rules()
    {
        $rules = $this->rules;
        $data  = $this->all();
        if (!empty($data['id'])){
        	$page = PageModel::find($data['id']);
        	if($page->url == $data['url']) {
                $rules = [
                	'url'=>'required|unique:pages,url,null,id,url,!='.$page->url
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
            'url.unique' => 'The url has already been taken.'
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