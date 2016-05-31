<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FindByAddressModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_find_by_address';

     protected $guarded = [];

    
}
