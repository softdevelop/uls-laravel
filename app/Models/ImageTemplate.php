<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ImageTemplate extends Model
{
	protected $table = 'image_template';

	protected $fillable = ['path', 'imageable_id', 'imageable_type'];
	/**
	* Get all of the owning imageable models.
	*/
    public function imageable()
    {
        return $this->morphTo();
    }
}