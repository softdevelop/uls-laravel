<?php namespace App\Models\Mongo\Cp;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ZoneRadiiModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'zone_radii';

	protected $fillable = ['radius'];
}