<?php namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CountriesModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'countries';

	protected $fillable = ['name', 'code'];
}