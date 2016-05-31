<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ThankYouModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_thank_you';

     protected $guarded = [];

    
}
