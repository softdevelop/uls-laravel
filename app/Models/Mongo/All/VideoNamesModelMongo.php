<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VideoNamesModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_video_names';

     protected $guarded = [];

    
}
