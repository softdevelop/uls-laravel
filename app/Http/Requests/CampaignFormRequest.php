<?php 
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\CampaignManagerModel;

class CampaignFormRequest extends FormRequest{
	
	public function rules()
    {
        $rules = $this->rules;
        $data  = $this->all();
        $rules = [
			'name'		 =>'required',
			'type'		 =>'required',
			'alias_name' =>'required|unique:campaigns_manager,alias_name,null,null,type,'.$data['type']
		];
        if (!empty($data['id'])){
        	$campaign = CampaignManagerModel::find($data['id']);
        	if($campaign->alias_name == $data['alias_name']) {
                $rules = [
                	'alias_name'=>'required|unique:campaigns_manager,alias_name,null,id,alias_name,!='.$campaign->alias_name . ',type,'.$data['type']
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