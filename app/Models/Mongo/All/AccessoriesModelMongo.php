<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AccessoriesModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'accessories';
    protected $guarded = [];
}
