<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ContactModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_contact';

     protected $guarded = [];

    
}
