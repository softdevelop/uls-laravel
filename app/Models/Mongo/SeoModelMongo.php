<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SeoModelMongo extends Eloquent
{
    protected $collection = 'seo';
    protected $connection = 'mongodb';
    protected $fillable = ['page_id', 'data'];
    
    public function __construct() {
        /* Connect to seo file config */
        include_once(base_path().'/lib/seo/APIexamples_PHP_1.21/config.php');
        require_once(base_path().'/lib/seo/APIexamples_PHP_1.21/lib/WSAclient.php');
        require_once(base_path().'/lib/seo/APIexamples_PHP_1.21/lib/WSAParser.php');

    }


    public function saveSeoData($id, $url)
    {	
        set_time_limit( 0 ); 
        // var_dump($id, $url);die;
        // ini_set('max_execution_time', 0);
        // self::where('page_id', intval($id))->first();
    	$toolID = 12;
    
	    $WSAclient = new \WSAclient(WSA_USER_ID,WSA_API_KEY);
	    
	    $toolParamArray= array('url'=>$url, 'checkOtherSubdomain' => 0);
	    $result=$WSAclient->newReport($toolID, $toolParamArray, WSA_SUBSCRIPTION_ID, 'xml', 'EN');
         unset($WSAclient);
         // $seo = new SeoModelMongo();
        $this->page_id = $id;
        $this->data = toArray($result);
        $this->save();

        return $this;
    }

    /**
     * [getSeoPageReport description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getSeoPageReport($pageId)
    {
        return self::where('page_id', intval($pageId))->first();
    }
}
