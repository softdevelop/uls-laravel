<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use PHPHtmlParser\Dom;
use App\Models\Mongo\SeoModelMongo;
use Carbon\Carbon;

class PagesModel extends Model
{
	protected $table = 'pages_sync';


	protected $fillable = [
		'name',
		'url',
		'parent_id',
        'updated_at'
	];

    public function getPageTitle($pageId)
    {
        return self::select('name')->where('id', $pageId)->get();
    }

    public function synPagesConsumer($url)
    {
        $pages = $this->lists('url', 'id')->all();
        foreach ($pages as $key => $value) {
          if($value==$url){
            return $key;
          }
        }
        return false;
    }

}