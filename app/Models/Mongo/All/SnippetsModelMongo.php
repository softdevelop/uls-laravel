<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SnippetsModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'all_snippets';

    protected $guarded = [];
    
}
