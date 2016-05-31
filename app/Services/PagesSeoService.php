<?php namespace App\Services;

use PHPHtmlParser\Dom;
use Sunra\PhpSimple\HtmlDomParser;
use Carbon\Carbon;
use App\Models\Mongo\SeoModelMongo;
use App\Models\PagesSeoModel;
use App\Http\Controllers\Controller;
use App\Models\PagesModel;

class PagesSeoService{

	/**
	 * [parseHtmlFromUrl description]
	 * get pages from url
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	public function parseHtmlFromUrl($urlLink)
	{
		//create new array all page
		$allPage=array();
		//get html page  with url
		$htmlDomParser= HtmlDomParser::file_get_html($urlLink);
		//get all tags id= column and h3 int it tag
		$columns = $htmlDomParser->find('#column h3');
		foreach ($columns as $key => $element) {
			//get name page parent
			$allPage[$key]['name']=$element->plaintext;
			//get page children
			$childrenPages=$element->next_sibling ();
			$count=0;
			//children page is empty and tag is different h3
			while (!empty($childrenPages) && $childrenPages->tag != 'h3') {
				//if tag is different a
				if($childrenPages->tag == 'a'){
					//get name page children
					$allPage[$key]['childrenPages'][$count]['name']=$childrenPages->plaintext;
					//get url page children
					$allPage[$key]['childrenPages'][$count]['url']=$childrenPages->href ;
					$count++;
				}
				// next children page
				$childrenPages = $childrenPages->next_sibling();
			}
			
		}
		return $allPage;
	
	}
	/**
     * [Seo save mongo with page id and url ]
     * @return [boleant] [true]
     */
    public function saveMongoSeo()
    {
    	$PagesSeoModel = new PagesSeoModel();
        //get 100 page new and order by ascending
        $savePageNewMongo = $PagesSeoModel->where('save_mongo',0)
        ->orderBy('updated_at', 'asc')
        ->take(100)
        ->get();
        foreach ($savePageNewMongo as $key => $pageMongo) {
                // Create a new Seo Model Mongo.
                $seoModelMongo = new SeoModelMongo();
                // Create new Seo with  page id and page url
                $seoModelMongo->saveSeoData($pageMongo->id, $pageMongo->url);
                $data['save_mongo'] =1;
                $updateCheck = $PagesSeoModel->find($pageMongo->id);
                // update columb save_mongo when seo create from page id
                $updateCheck->update($data);
        }    
        //if new pages <100 
        if(count($savePageNewMongo)<100){
            //get page was updated more than 30 days and updated_at order by  ascending and the missing link after creating a new page
            $seoData = $PagesSeoModel->where('updated_at', '<=', Carbon::parse(date('Y-m-d', strtotime("-30 day")))->toDateTimeString())
            ->orderBy('updated_at', 'asc')
            ->take(100-count($savePageNewMongo))
            ->get();
            foreach ($seoData as $key => $value) {
                // Create a new Seo Model Mongo.
                $seoModelMongo = new SeoModelMongo();
                // delete Seo with  page id
                $seoModelMongo->where('page_id', $value->id)->delete();
                // Create new Seo with  page id and page url
                $seoModelMongo->saveSeoData($value->id, $value->url);

                $dataNew['updated_at'] = date("Y-m-d h:i:s");
                
                $PageUpdate = $PagesSeoModel->find($value->id);
                //update columb updated_at when seo create from page id
                $PageUpdate['updated_at']= $dataNew['updated_at'];

                $PageUpdate->update();
            }
        }
        return true;
    }

    /**
     * Get page to show page tree
     * @param  integer $parent_id ParentID
     * @return Array              Array pages
     */
    public static function getPagesTree($parent_id = 0)
    {
        $seoModelMongo = new SeoModelMongo();
        $pageModel = new PagesModel;
        /* If not input parent_id then parent id is 0 */
        if(empty($pageModel->parent_id)) $pageModel->parent_id = 0;
        /* Get all pages have parent_id = parent_id input and sort by id */
        $items = \DB::table('pages_sync')->where('parent_id', $parent_id)->orderBy('id', 'asc')->get();
        /* Foreach pages to add data for child pages  */
        foreach($items as $item)
        {
            $hasSubFolder = \DB::table('pages_sync')->where('parent_id', $item->id)->count();
            /* If page has child pages */
            if($hasSubFolder){
                /* Add child page to array children */
                $item->children = self::getPagesTree($item->id);   
            }
            if($item->parent_id == 0) {
                $item->folder = true;
            } else {
                $item->hideCheckbox = true;
            }
           
            $item->title = $item->name;
            $item->key = $item->id;

            //insert data seo
            $data = $seoModelMongo->getSeoPageReport($item->id);
            //error
            if ( empty($data['data']['output']['diagnosticsInfo']['errorList']['entry']) ) {
                 $item->error = 0;
            } else {
                $item->error = count($data['data']['output']['diagnosticsInfo']['errorList']['entry']);
            }

            //warning
            if ( empty($data['data']['output']['diagnosticsInfo']['warningList']['entry']) ) {
                $item->warning = 0;
            } else {
                $item->warning = count($data['data']['output']['diagnosticsInfo']['warningList']['entry']);
            }

            //page rangk
            if ( empty($data['data']['output']['pageInfo']['PageRank'] ) ){
                 $item->pageRank = 0;
            } else {
                $item->pageRank = $data['data']['output']['pageInfo']['PageRank'];
            }

            unset($item->name);
            unset($item->id);
        }
        return $items;
    }

    /**
     * Show all folder on parent page
     * @return Array
    */
    public static function getChildPagesById($id)
    {
        $pageModel = new PagesModel;
        /* Search child pages of Page selected with page id */
        $items = $pageModel->where('parent_id', $id)->get();
        /* Foreach pages to add data for child pages  */
        foreach ($items as $item) {
            $item->folder = true;
            $item->title = $item->name;
            $item->key = $item->id;
            $seoModelMongo = new SeoModelMongo();
            /* Get date seo page report to show in table page */
            $data = $seoModelMongo->getSeoPageReport($item->id)->toArray();
            $item->error = count($data['data']['output']['diagnosticsInfo']['errorList']);
            $item->warning = count($data['data']['output']['diagnosticsInfo']['warningList']['entry']);
            $item->pageRank = $data['data']['output']['pageInfo']['PageRank'];
            unset($item->id);
            unset($item->name);
        }
        return $items;
    }

}