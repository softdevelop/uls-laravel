<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class LasersOptionsModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_configurator_lasers_options';

    protected $guarded = [];
    
}
