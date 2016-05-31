<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FormsConfiguratorContactModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_forms_configurator_contact';

     protected $guarded = [];

     /**
      * [requestHelp description]
      * @param  [type] $data     [description]
      * @param  [type] $cp_email [description]
      * @return [type]           [description]
      */
     public static function requestHelp($data, $email) {
		\Mail::send('emails.configurator.help', ['data' => $data], function ($m) use ($email) {
            $m->to($email)->subject('Configurator Form Submitted!');
        });
		return self::create($data);	
     }
    
}
