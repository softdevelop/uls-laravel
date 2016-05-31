<?php namespace App\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PostWrappers extends Eloquent {
    protected $collection = 'post_wrappers';
    protected $connection = 'mongodb';
    protected $fillable = ['html', 'startField'];

}