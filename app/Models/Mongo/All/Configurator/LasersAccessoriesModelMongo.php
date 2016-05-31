<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LasersAccessoriesModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_configurator_lasers_accessories';

    protected $guarded = [];

}
