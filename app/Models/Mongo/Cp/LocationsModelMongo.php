<?php namespace App\Models\Mongo\Cp;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LocationsModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'locations';

	protected $fillable = ['city','state','page_id', 'google_cc','language_code','address_1','address_2', 'name_url', 'website', 'phone_1','phone_2','fax','email',
						   'zip', 'source','location_url','channel_partner_tld', 'europe', 'tagline', 'company_id', 'country_id', 'location_id'];

	public function dealerLocations()
    {
        return $this->belongsTo('App\Models\Mongo\Cp\DealersLocationModelMongo', '_id', 'location_id');
    }

    public function country()
    {
    	return $this->belongsTo('App\Models\Mongo\CountriesModelMongo', 'country_id', '_id');
    }
}