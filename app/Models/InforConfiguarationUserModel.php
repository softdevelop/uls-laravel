<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InforConfiguarationUserModel extends Model
{
	protected $table = 'infor_guide_config_user';

	protected $guarded  = [];

	/**
	 * [guidedConfigInforConfigUser description]
	 * @return [type] [description]
	 */
	public function guidedConfiguaration()
	{
		return $this->hasMany('App\Models\GuidedConfiguarationModel','infor_config_user_id');
	}

	/**
	 * [addInforConfiguarationUser description]
	 *
	 * @author [Kim Bang] <[bang@httsolution.com]>
	 * @param [type] $data [description]
	 */
	public function addInforConfiguarationUser($data = [])
	{
		$result = [];
		
		if (!empty($data)) {
			$result = self::create($data);
		}

		return $result;
	}
}