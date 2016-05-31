<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OptionsTextActiveModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_configurator_options_active';

    protected $guarded = [];
    

}
