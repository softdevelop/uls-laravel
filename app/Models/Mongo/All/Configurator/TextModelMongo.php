<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class TextModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_configurator_text';

    protected $guarded = [];
    
}
