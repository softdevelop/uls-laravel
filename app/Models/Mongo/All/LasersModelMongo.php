<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LasersModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_lasers';

    protected $guarded = [];
    
    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allSpecs()
    {
        return $this->hasMany('App\Models\Mongo\All\SpecsModelMongo', 'laser_id');
    }

    /**
     * select_laser
     * @return [type] [description]
     */
    public static function selectLaser($laser)
    {
    	$laserId = self::where('link', $laser)->first()->_id;
    	return $laserId;
    }

    /**
     * getPlatformInterest
     * @param  [type] $fullLink [description]
     * @return [type]           [description]
     */
    public static function getPlatformInterest($fullLink)
    {
        $data = self::where('full_link', $fullLink)->first()->platform_interest;
        return $data;
    }
}
