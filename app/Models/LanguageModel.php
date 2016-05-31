<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class LanguageModel extends Model
{

	protected $table = 'languages';

	protected $fillable = ['name', 'code', 'native_name', 'direction', 'active', 'alias_name'];

	/**
     * The region that belong to the language.
     */
    public function regions()
    {
        return $this->belongsToMany('App\Models\RegionModel', 'region_language', 'language_id', 'region_id');
    }

    public function translations()
    {
        return $this->hasMany('App\Models\TranslationQueueModel','language_id');
    }

	/**
	 * show all languages active
	 * @return json languages
	 */
	public function getActiveLanguages()
	{
		$languages = $this->where('active', '!=', '0') -> get();
		return $languages;
	}

	/**
	 * get list language active
	 * @return json 	languages list (code, id)
	 */
	public function getListActiveLanguages()
	{
		$languages = $this->where('active', '1')->lists('code', 'id')-> all();
		return $languages;
	}

	/**
	 * get all list languages
	 * @return json list language
	 */
	public function getListLanguage()
	{
		$languages = $this->where('active',1)->lists('name', 'id')->all();
		return $languages;
	}

	/**
	 * get List Language contain Code And Name
	 * @return json list language
	 */
	public function getLanguageName($code)
	{
		$languages = $this->where('active',1)->where('code',$code)->lists('name')->first();
		return $languages;
	}

	public function getListLanguageWithCode($code)
	{
		$languages = $this->where('active',1)->where('code', '<>',$code)->lists('name', 'code')->all();
		return $languages;
	}

	/**
	 * create new languages
	 * @param  object $data data
	 * @return array 		status, languages
	 */
	public function createNewLanguage($data)
	{
		$data['alias_name'] = str_replace(" ", "_", strtolower($data['name']));
		$language = $this->create($data);
		return ['language' => $language];
	}

	/**
	 * edit a language
	 * @param  int $id   id of language edit
	 * @param  object $data data
	 * @return array       status, language
	 */
	public function updateLanguageById($id, $data)
	{
		$language = $this->find($id);
		$language->update($data);
		return ['language' => $language];
	}

	/**
	 * [checkExistLanguage description]
	 * check exist language in system
	 *
	 * @author [Kim Bang] <[bang@httsolution.com]>
	 * @param  [type] $code [description]
	 * @return [type]       [description]
	 */
	public static function checkExistLanguage($code)
	{
		$query = self::where(function($query) use($code){
			if (is_array($code)) {
				$query->whereIn('code', array_values($code));
			} else {
				$query->where('code', $code);
			}
		})->get();

		//check exist region?
		if (is_array($code) && count($query) == count($code)
			|| !is_array($code) && count($query)) {

			return true;
		}

		return false;
	}
}