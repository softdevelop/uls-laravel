<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SpecsModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_specs';

    protected $guarded = [];

    /**
     * [lasers description]
     * @return [type] [description]
     */
  	public function lasers() 
  	{
  		return $this->belongsTo('App/Models/Mongo/All/LasersModelMongo', 'laser_id');
  	}
    
}
