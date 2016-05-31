<?php namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CompaniesModelMongo extends Eloquent
{
    protected $connection = 'mongodb';	
	protected $collection = 'companies';

	protected $fillable = ['name', 'code'];
}