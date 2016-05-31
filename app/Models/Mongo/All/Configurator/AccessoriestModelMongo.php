<?php namespace App\Models\Mongo\All\Configurator;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AccessoriestModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'configurator_accessories_text';

    protected $guarded = [];

    /**
     * [lasers description]
     * @return [type] [description]
     */
    public function accessoriesImages() 
    {
       return $this->belongsTo('App\Models\Mongo\All\AccessoriesImagesModelMongo', 'image_id');

    }

    /**
     * [lasers description]
     * @return [type] [description]
     */
    public function allLinksConfiguratorAccessories() 
    {
       return $this->belongsTo('App\Models\Mongo\All\LinksConfiguratorAccessories', '_id', 'accessory_id');

    }
}
