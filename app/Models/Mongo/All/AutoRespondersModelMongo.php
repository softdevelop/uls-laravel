<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AutoRespondersModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_autoresponders';

     protected $guarded = [];
    
}
