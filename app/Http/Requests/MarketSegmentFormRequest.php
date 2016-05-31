<?php 
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Models\MarketSegmentModel;

class MarketSegmentFormRequest extends FormRequest{
	protected $rules = [
		'name'		 =>'required',
		'active'	 =>'required',
		'alias_name' =>'required|unique:marketsegments,alias_name'
	];

	public function rules()
    {
        $rules = $this->rules;
        $data  = $this->all();
        if (!empty($data['id'])){
        	$market_segment = MarketSegmentModel::find($data['id']);
        	if($market_segment->alias_name == $data['alias_name']) {
                $rules = [
                	'alias_name'=>'required|unique:marketsegments,alias_name,null,id,alias_name,!='.$market_segment->alias_name
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