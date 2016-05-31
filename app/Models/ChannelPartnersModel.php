<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ChannelPartnersModel extends Model
{
	protected $table = 'channel_partners';
	protected $fillable = ['name', 'address','suite','city','zipcode', 'telephone', 'email', 'region_id','alias_name'];

	public function region()
    {
        return $this->belongsTo('App\Models\RegionModel','region_id');
    }


	/**
	 * create a new channel partner
	 * @param  [object] $data data
	 * @return array       status, error, channel partner
	 */
	public function createChannelPartner($data)
	{
		$partner = $this -> create($data);
		return $partner;
	}

	/**
	 * edit a channel partner
	 * @param  object $data data
	 * @param  int $id   id of channel partners to edit
	 * @return array       status, error, channel partner
	 */
	public function editChannelPartner($data)
	{
		$partner = $this;
		$partner -> update($data);
		return $partner;
	}
}