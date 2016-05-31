<?php namespace App\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Fields extends Eloquent {
    protected $collection = 'fields';
    protected $connection = 'mongodb';
    protected $fillable = ['field_id', 'endField', 'preWrapperHtml', 'postWrapperHtml', 'col', 'orveride_filed', 'pre_addon', 'post_addon', 'placeholder',
						   'html_attributes','term', 'Fields', 'modal', 'colPre', 'colForm', 'colPost'];

	public function postWrappers()
	{
	    return $this->hasMany('App\Models\Mongo\PostWrappers');
	}

}

