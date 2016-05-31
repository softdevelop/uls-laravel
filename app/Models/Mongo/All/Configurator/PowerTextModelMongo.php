<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PowerTextModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'configurator_power_text';

     protected $guarded = [];
    
}
