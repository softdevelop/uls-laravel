<?php namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CoordinatesModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'coordinates';

	protected $fillable = ['company_id', 'latitude', 'longitude', 'map_id', 'channel_partner_id'];
}