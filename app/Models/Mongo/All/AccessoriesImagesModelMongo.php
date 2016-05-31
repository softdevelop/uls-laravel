<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AccessoriesImagesModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_accessories_images';

     protected $guarded = [];

    
}
