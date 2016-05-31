<?php namespace App\Models\Mongo\Cp;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DealersLocationModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'dealers_locations';

	protected $fillable = ['channel_partner_name', 'channel_partner_id', 'language_code', 'location_id', 'group_cp_id'];

	public function location()
    {
        return $this->belongsTo('App\Models\Mongo\Cp\LocationsModelMongo', 'location_id', '_id');
    }
}