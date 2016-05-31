<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OptionsTextModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_configurator_options_text';

    protected $guarded = [];

    /**
     * [lasers description]
     * @return [type] [description]
     */
  	public function optionsActive() 
  	{
       return $this->belongsTo('App\Models\Mongo\All\Configurator\OptionsTextActiveModelMongo', 'option_id');

  	}
    
    /**
     * [lasers description]
     * @return [type] [description]
     */
  	public function videoNames() 
  	{
       return $this->belongsTo('App\Models\Mongo\All\VideoNamesModelMongo', 'video_id');

  	}

    /**
     * [lasers description]
     * @return [type] [description]
     */
    public function lasersOptions() 
    {
       return $this->belongsTo('App\Models\Mongo\All\Configurator\LasersOptionsModelMongo', 'option_id');

    }
}
