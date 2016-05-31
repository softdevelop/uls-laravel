<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mongo\SeoModelMongo;
use Carbon\Carbon;

class PagesSeoModel extends Model
{
	protected $table = 'pages_sync';


	protected $fillable = [
		'name',
		'url',
		'parent_id',
        'updated_at',
        'save_mongo'
	];

    public function savePagesSeoModel($data) {
        return $this->create($data);
    }

    public function getPageTitle($pageId)
    {
        return self::select('name')->where('id', $pageId)->get();
    }
    /**
     * [save pages with array is got from sync page ]
     * @param  [array] $synPages synPages
     * @return [boolean]           [true or false]
     */
    public function saveSynPages($synPages)
    {   
        set_time_limit( 0 ); 
        // list parent page
        $pagesParent = $this->where('parent_id',0)->lists('name', 'id')->all();
        // list child page
        $pagesChild = $this->where('parent_id', '<>', 0)->lists('url', 'id')->all();
        foreach ($synPages as $key => $synPage) {
            //Check name of Parent if doesn't exist in list parent page
            if (!in_array($synPage['name'], array_values($pagesParent))) {
                //create that page parent with url is 0 and parent_id is 0 and page name
                $createPageParent = $this->create(['name' =>  $synPage['name'], 'url' =>0, 'parent_id' => 0]);
                // get id created
                $parentId = $createPageParent->id;
            }
            //Check name of Parent if exists in list parent page
            else{
                //get page parent with name 
                $getPageWithName=$this->where('name', $synPage['name'] )->where('parent_id',0)->get();
                
                $parentId = $getPageWithName[0]['id'];
            }  
           foreach ($synPage['childrenPages'] as $key1 => $childrenPage) {
                //Check url of child if doesn't exist in list child page
                if (!in_array($childrenPage['url'], array_values($pagesChild))) {
                    //create that page child with url and parent_id and page name
                    $childrenValue = $this->create(['name' =>  $childrenPage['name'], 'url' =>$childrenPage['url'], 'parent_id' => $parentId ]);
                }
               
           }
        }
        return true;
    }

}