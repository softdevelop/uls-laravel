<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class LinksConfiguratorAccessories extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_links_configurator_accessories';

     protected $guarded = [];

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
  	public function accessoriesText() 
  	{
       return $this->belongsTo('App\Models\Mongo\All\Configurator\AccessoriestModelMongo', 'accessory_id');

  	}
}
