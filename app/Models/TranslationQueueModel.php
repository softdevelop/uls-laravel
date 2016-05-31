<?php namespace App\Models;

use App\Models\LanguageModel;
use DateTime;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class TranslationQueueModel extends Model
{
	protected $table = 'translation_queue';

	protected $fillable = ['name', 'meta', 'title', 'heading','subheading','description','status','priority','page_id','language_id'];

	public function page()
    {
        return $this->belongsTo('App\Models\PageModel','page_id');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\LanguageModel','language_id');
    }

	/**
	 * get page need translate
	 * @return array object list page translate
	 */
	public function getTranslation()
	{
		$translations = TranslationQueueModel::get();
		return $translations;
	}


	/**
	 * get a page to need translate
	 * @param  int $id id of page need transalte
	 * @return translate     translate
	 */
	public function getTranslationById($id)
	{
		$translation = TranslationQueueModel::find($id);
		return $translation;
	}

	/**
	 * translate a page
	 * @param  object $data data
	 * @param  int $id   id of page need translate
	 * @return array       status,page translate
	 */
	public function editTranslation($data, $id)
	{
		$status = 1;
		$translation_editor = [];
		$data['updated_at'] = new DateTime();

		$translation_editor = TranslationQueueModel::find($id);

		if(!$translation_editor) {
			$status = 0;
		} else {
			$translation_editor -> update($data);
			
			$timeNow = new DateTime();
			$updated_at = new DateTime($translation_editor['updated_at']);
			$dateDiff = ($timeNow->diff($updated_at));
			$translation_editor['last_updated'] = $dateDiff;
		}
		return ['status' => $status, 'translation_editor' => $translation_editor];
	}
}