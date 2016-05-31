<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SeoContentModel extends Eloquent
{
    protected $collection = 'seo_content';
    protected $connection = 'mongodb';
    protected $fillable = ['content_id', 'data','status','url'];
    
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
        $this->content_id = $id;
        $this->url = $url;
        $this->data = toArray($result);
        $this->status = 1;
        $this->save();

        return $this;
    }

    /**
     * [getSeoPageReport description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getContentByPageId($content_id)
    {
        return self::where('content_id', $content_id)->first();
    }
}
