<?php namespace App\Models;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\PageModel;
use App\Models\RegionModel;
use App\Models\LanguageModel;
use App\Models\MarketSegmentModel;
use App\Models\TranslationQueueModel;
use App\Models\Mongo\SeoContentModel;
use App\Models\TemplateManagerModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mongo\ContentModelMongo;
use App\Services\TimeService;
use PHPHtmlParser\Dom;

class PageModel extends Model
{
	protected $table = 'pages';

	protected $fillable = [
		'name',
		'url',
		'dateLiveBy',
		'dateAvailable',
		'toDate',	
		'parent_id',
		'user_id'
	];

	/**
     * The region that belong to the page.
     */
    public function regions()
    {
        return $this->belongsToMany('App\Models\RegionModel', 'page_region', 'page_id', 'region_id');
    }

    /**
     * The language that belong to the page.
     */
    public function languages()
    {
        return $this->belongsToMany('App\Models\LanguageModel', 'page_language', 'page_id', 'language_id');
    }

    /**
     * The marketsegment that belong to the page.
     */
    public function marketsegments()
    {
        return $this->belongsToMany('App\Models\MarketSegmentModel', 'page_marketsegment', 'page_id', 'marketsegment_id');
    }

    /**
     * the translate that has many to the page
     * @return [type] [description]
     */
    public function translations()
    {
        return $this->hasMany('App\Models\TranslationQueueModel','page_id');
    }

    /**
     * the template that has many to the page
     * @return [type] [description]
     */
    public function templates()
    {
        return $this->belongsTo('App\Models\TemplateManagerModel','template_id');
    }

	/**
	 * get List page
	 * @return object 
	 */
	public function getListsPage()
	{
		return $this->lists('name', 'id');
	}

	/**
	 * check url of page has been exist?
	 * @param  int $id  id of page
	 * @param  string $url url of page
	 * @return int      1 or 0
	 */
	public function checkPageUrlExists ($id, $url)
	{
		if(!$id){
			$result = $this->where('url', $url)->count();
			return $result;
		}else{
			$result = $this->where('url', $url)->where('id', '!=', $id)->count();
			return $result;
		}
		
	}

	/**
	 * get page by url
	 * @param  string $url url
	 * @return object      pages
	 */
	public function getPageByUrl($url)
	{
		return self::where('url', $url)->first();
	}

	/**
	 * get Page by page id
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getPageById($pageId)
	{
		$item = $this->where('id', $pageId)->first();
  		return $item;
	}

	/**
	 * create a new page
	 * @param  object $data data
	 * @return array       page
	 */
	public function createNewPage($data)
	{
		$dom = new Dom;
		//init content mongo
		$contentMongo = new ContentModelMongo;

		//declare data contain field to save pages in mysql
		$data['user_id'] = \Auth::user()->id;

		//create page
		// $data['dateLiveBy'] = (new \DateTime($data['dateLiveBy']))->format('Y-m-d');
		// $data['dateAvailable'] = (new \DateTime($data['dateAvailable']))->format('Y-m-d');
		// $data['toDate'] = (new \DateTime($data['toDate']))->format('Y-m-d');
		
		foreach ($data['content'][$data['template']] as $key => &$value) {

			$dom->load($value);

			//Find insert block
			$findDomBlock = $dom->find('.insert-block');
			foreach ($findDomBlock as $sDom) {
				$blockId = $sDom->getAttribute('insert-block');
				// $value = str_replace(' />','>',$value);
				$strReplace = $sDom->outerHtml;
				$value = str_replace($strReplace,"__insert_block(".$blockId.")__",$value);
			}
			//find insert page
			$findDomInsertPage = $dom->find('.insert-page');
			foreach ($findDomInsertPage as $pageDom) {
				$strReplacePage = $pageDom->outerHtml;

				$name = $pageDom->innerHtml;
				$pageId = $pageDom->getAttribute('insert-page');
				$target = ($pageDom->getAttribute('target') == null)? 'false' : 'true';

				$value = str_replace($strReplacePage,"__insert_page(".$pageId.",".$name.",".$target.")__",$value);
			}
		}
		
		$page = $this->create($data);

		/* Add region, language and marketsegment for page */
		$page->regions()->sync(array_keys($data['region']));
		$page->languages()->sync(array_keys($data['language']));
		$page->marketsegments()->sync(array_keys($data['marketSegment']));

		//contents
		$contents = array_shift((array_values($data['content'])));

		/* If not isset template fields then set template field is array null */
		if(!isset($data['templateField'])){
			$data['templateField'] = [];
		}

		//create content contents in mongo
		$contentMongo->create([
			'page_id' => $page->id, 
			'template_id' => $data['template'],
			'content' => $contents,
			'field' => $data['templateField']
		]);
		$SeoContentModel = new SeoContentModel();

        $SeoContentModel->saveSeoData($page->id,$page->url);
 
		/*Set value page to show in fancytree*/
		$page->key = $page->id;
		unset($page->id);
		
		return ['page' => $page];
	}
	/**
	 * create a new page
	 * @param  object $data data
	 * @return array       page
	 */
	public function createNewFolder($data)
	{
		$item['user_id']  	 = \Auth::user()->id;
		
		$item['parent_id'] =0;

		$item['name'] =$data['folder_name'];

		$item['url'] =$data['url'];
		//create page
		$page = $this->create($item);
		 /* Set data to show page tree */
        $page->title = $page->name;
        $page->key = $page->id;
        $page->folder = true; 
        unset($page->id);
        
		return ['page' => $page];
	}

	/**
	 * update page by id page
	 * @param  int $id   id of page
	 * @param  object $data data
	 * @return array       status, page
	 */
	public function updatePageById($data)
	{
		$dom = new Dom;
		/* Init content mongo */
		$contentMongo = new ContentModelMongo;

		/* Declare data contain field to save pages in mysql */
		$data['user_id'] = \Auth::user()->id;

		foreach ($data['content'][$data['template']] as $key => &$value) {
			$value = str_replace('&#8203;','',$value);
			$dom->load($value);

			$findDom = $dom->find('.insert-block');

			foreach ($findDom as $sDom) {

				$blockId = $sDom->getAttribute('insert-block');

				// $value = str_replace(' />','>',$value);
				$strReplace = $sDom->outerHtml;
				$value = str_replace($strReplace,"__insert_block(".$blockId.")__",$value);
			}
			
			//find insert page
			$findDomInsertPage = $dom->find('.insert-page');
			foreach ($findDomInsertPage as $pageDom) {
				$strReplacePage = $pageDom->outerHtml;

				$name = $pageDom->innerHtml;
				$pageId = $pageDom->getAttribute('insert-page');
				$target = ($pageDom->getAttribute('target') == null)? 'false' : 'true';

				$value = str_replace($strReplacePage,"__insert_page(".$pageId.",".$name.",".$target.")__",$value);
			}
		}

		$this->update($data);

		/* Add region, language and marketsegment for page */
		$this->regions()->sync(array_keys($data['region']));
		$this->languages()->sync(array_keys($data['language']));
		$this->marketsegments()->sync(array_keys($data['marketSegment']));

		/* If template fields is not exists */
		if(!isset($data['templateField'])){
			$data['templateField'] = [];
		}

		/* Delete content of page */
		ContentModelMongo::where('page_id', intval($this->id))->delete();
		
		if (isset($data['content'], $data['templateField']) && !empty($data['content']) && !empty($data['templateField'])) {
			/* Contents */
			$contents = array_shift((array_values($data['content'])));

			$contents = array_where($contents, function($key, $value){
			    return !empty($key);
			});

			/* Fields */
			$fileds = array_shift((array_values($data['templateField'])));

			/* Create content contents in mongo */
			$contentMongo->create([
				'page_id' => $this->id, 
				'template_id' => $data['template'],
				'content' => $contents,
				'field' => $fileds
			]);	
		}	

		/*Set value page to show in fancytree*/
		$this->key = $this->id;
		unset($this->id);

		return ['page' => $this];
	}
}