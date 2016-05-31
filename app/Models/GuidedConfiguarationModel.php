<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GuidedConfiguarationModel extends Model
{
	protected $table = 'guided_configuarator';

	protected $guarded  = [];

	/**
	 * [guidedConfigInforConfigUser description]
	 * @return [type] [description]
	 */
	public function inforConfiguarationUser()
	{
		return $this->belongsTo('App\Models\InforConfiguarationUserModel','infor_config_user_id');
	}

	/**
	 * [addDetailGuidedConfiguaration description]
	 *
	 * @author [Kim Bang] <[bang@httsolution.com]>
	 * @param array $data [description]
	 */
	public function addDetailGuidedConfiguaration($data = [])
	{
		$result = [];

		$status = 0;

		$result = self::create($data);

		if (!empty($result)) {
			$status = 1;
		}

		return ['status' => $status, 'result' => $result];
	}
}