<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class PositionModel extends Model
{
	protected $table = 'positions';

	protected $fillable = ['name', 'alias_name', 'file_name'];


    public function templates()
    {
        return $this->belongsToMany('App\Models\TemplateManagerModel', 'template_position', 'template_id', 'position_id');
    }

    public function blocks()
    {
        return $this->belongsToMany('App\Models\BlockModel', 'template_position', 'position_id', 'block_id');
    }

    /**
     * get List Position with alias name and id
     * @return Array 
     */
    public function getListPositionWithAliasNameId()
    {
        return self::lists('alias_name', 'id')->all();
    }

    /**
     * [getListsIdWithImageNameOfPosition description]
     * @return [type] [description]
     */
    public function getListsIdWithImageNameOfPosition(){
        return self::lists('file_name', 'id')->all();
    }

}