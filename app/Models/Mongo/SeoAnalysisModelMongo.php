<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SeoAnalysisModelMongo extends Eloquent
{
    protected $collection = 'seo_analysis';
    protected $connection = 'mongodb';
    protected $fillable   = ['url', 'data'];

    public function __construct() {
        /* Connect to seo file config */
        include_once(base_path().'/lib/seo/APIexamples_PHP_1.21/config.php');
        require_once(base_path().'/lib/seo/APIexamples_PHP_1.21/lib/WSAclient.php');
        require_once(base_path().'/lib/seo/APIexamples_PHP_1.21/lib/WSAParser.php');
    }

    /**
     * Save seo analysis in database
     * @param  string $url domain url
     * @return Array       array data seo analysis
     */
    public function saveSeoAnalysis($url)
    {
        $domainStatistics = self::where('url', $url);

        /* If isset domain statistics in mongo db */
        if($domainStatistics->count()){
            return $domainStatistics->first();

        }else{
            set_time_limit( 0 );

            $toolID = 2;

            $WSAclient = new \WSAclient(WSA_USER_ID,WSA_API_KEY);

            $toolParamArray= array('url'=>$url, 'checkOtherSubdomain' => 0);
            $result = $WSAclient->newReport($toolID, $toolParamArray, WSA_SUBSCRIPTION_ID, 'json', 'EN');
            unset($WSAclient);

            $this->url = $url;
            $this->data = json_decode($result);
            $this->save();

            return $this;
        }
    }
}
