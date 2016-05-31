<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class RegionModel extends Model
{
	protected $table = 'regions';

	protected $fillable = ['name', 'code', 'active','alias_name'];

	/**
     * The region that belong to the language.
     */
    public function pages()
    {
        return $this->belongsToMany('App\Models\PageModel', 'page_region', 'page_id', 'region_id');
    }

	/**
     * The language that belong to the region.
     */
    public function languages()
    {
        return $this->belongsToMany('App\Models\LanguageModel', 'region_language', 'region_id', 'language_id');
    }

    public function partners()
    {
        return $this->hasMany('App\Models\ChannelPartnersModel','region_id');
    }


	/**
	 * get lists regions by region ID
	 * @return [type] [description]
	 */
	public function getListIdRegion()
	{
		$db = RegionModel::where('active',1)->lists('name','id');
		return $db; 
	}

	/**
	 * create a new region
	 * @param [object] $data [a object region]
	 */
	public function CreateRegion($data)
	{
		$region = $this -> create($data);
		$region->languages()->sync($data['languages']);
		$region['languages'] = $region->languages()->get();
		return $region;
	}

	/**
	 * Edit a region
	 * @param [object] $data [a object region]
	 * @param [int] $id   [id of region to edit]
	 */
	public function EditRegion($data)
	{
		$region = $this;
		$region->update($data);
		$region->languages()->sync($data['languages']);
		$region['languages'] = $region->languages()->get();
		return $region;
	}

	/**
	 * [checkExistRegionModel description]
	 *
	 * @author [Kim Bang] <[bang@httsolution.com]>
	 * @param  [type] $regions [description]
	 * @return [type]          [description]
	 */
	public static function checkExistRegionModel($regions)
	{
		$query = self::where(function($query) use($regions){
			if (is_array($regions)) {
				$query->whereIn('code', array_values($regions));
			} else {
				$query->where('code', $regions);
			}
		})->get();

		//check exist region?
		if (is_array($regions) && count($query) == count($regions)
			|| !is_array($regions) && count($query)) {

			return true;
		}

		return false;
	}

}