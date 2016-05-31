<?php namespace App\Models\Mongo\Cp;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DealersModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'dealers';

	protected $fillable = ['channel_partner_id','company_id','zone_radius_id','cp_manager_id', 'active', 'icon', 'education', 'find_by_representative'];

	public function dealerLocation()
    {
        return $this->belongsTo('App\Models\Mongo\Cp\DealersLocationModelMongo', 'channel_partner_id', 'channel_partner_id');
    }

    public function companie()
    {
    	return $this->belongsTo('App\Models\Mongo\CompaniesModelMongo', 'company_id', '_id');
    }
}