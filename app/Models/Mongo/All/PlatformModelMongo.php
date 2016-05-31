<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Mongo\LanguagesModelMongo;

class PlatformModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_platform';

    protected $guarded = [];
    
     /**
     * [lasers description]
     * @return [type] [description]
     */
  	public function lasers() 
  	{
       return $this->belongsTo('App\Models\Mongo\All\LasersModelMongo', 'laser_id');

  	}

    /**
     * spec
     * @return [type] [description]
     */
    public function spec()
    {
        $language = LanguagesModelMongo::findLanguage(getLanguage());
        return $this->belongsTo('App\Models\Mongo\All\SpecsModelMongo', 'type', 'type')->where('language_id', $language->_id);
    }
}
