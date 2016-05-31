<?php namespace App\Models\Mongo\Cp;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CpToolsOpenHousesModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'cp_tools_open_houses';

	protected $fillable = ['channel_partner_id','language_code','open_house','event_dates_text', 'event_date','end_date','event_time','place', 'details','link'];
}