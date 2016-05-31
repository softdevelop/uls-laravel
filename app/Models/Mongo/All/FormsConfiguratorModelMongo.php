<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FormsConfiguratorModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_forms_configurator';

    protected $guarded = [];

    /**
     * submitConfiguration
     * @return [type] [description]
     */
    public static function submitConfiguration($formData)
    {
       if ($formData['FName'] != $formData['LName']) {
          $formData['is_spam'] = 0;
       } else {
          $formData['is_spam'] = 1;
       }
       return self::create($formData);
    }
    
}
