<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class CampaignManagerModel extends Model
{
	protected $table = 'campaigns_manager';

	protected $fillable = ['name', 'type', 'alias_name'];

	/**
	 * get list campaign
	 * @return json  	campaigns 
	 */
	public function getListCampaign()
	{
		$Campaigns = $this->all();
		return $Campaigns;
	}

	/**
	 * create new campaign
	 * @param  object $data data
	 * @return array       status, campaign
	 */
	public function createNewCampaign ($data) 
	{
		$data['alias_name'] = str_replace(" ", "_", strtolower($data['name']));
		$campaign = $this->create($data);
		return ['campaign'=>$campaign];
	}

	/**
	 * edit a campaign
	 * @param  int $id   id of campaign need edit
	 * @param  object $data data update
	 * @return array       status,campaign
	 */
	public function editCampaign($id, $data)
	{
		$campaign = $this->find($id);
		$data['alias_name'] = str_replace(" ", "_", strtolower($data['name']));
		$campaign->update($data);
		return ['campaign' => $campaign];
	}
}