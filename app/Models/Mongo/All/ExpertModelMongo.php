<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ExpertModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_expert';

    protected $fillable = [
    							'language_id', 
    							'international',
    							'contact',
    							'questions',
    							'sales',
    							'us',
    							'send_message',
    							'find_rep',
    							'tech_support',
    							'support_request',
    							'europe',
    							'japan',
    							'view_map',
    							'office',
    							'sign_up_for_newsletter',
    							'subscribe',
    						];
    
}
