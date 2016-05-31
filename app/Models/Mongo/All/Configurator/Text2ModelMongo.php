<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Text2ModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_configurator_text_2';

    protected $guarded = [];
    
}
