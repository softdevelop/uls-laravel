<?php namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Services\TrafficService;

class TrafficModelMongo extends Eloquent
{
    //set collection is traffic
    protected $collection = 'traffic';
    //connection mongodb
    protected $connection = 'mongodb';

    protected $fillable = ['rows', 'page_id'];

    /**
     * [saveTrafficWithUrl description]
     * @param  [type] $date [description]
     * @param  [type] $url  [description]
     * @return [type]       [description]
     */
    public function saveTrafficWithUrl($startDate, $endDate, $page_id, $url=null)
    {
        set_time_limit( 0 ); 
        //get analytics from googles
        $analytics = TrafficService::getService();
        //get profile
        $profile = TrafficService::getFirstProfileId($analytics);
        //date range
        $dateRange = createDateRangeArray($startDate, $endDate);
        //get 7 days
        foreach ($dateRange as $key => $date) {
            $results = TrafficService::getResults($analytics, $profile, $url, $date);
            $results = TrafficService::printResults($results);
            if($results == 'No results found.n') {
                continue;
            }
            //foreach record
            foreach ($results as $key1 => $value1) {
                $value1[14] = $date;
                $this->create(['rows' => $value1, 'page_id' => $page_id]);
            }
        }
        return 1;
    }

    public function getTraffic($page_id)
    {
    	return self::where('page_id', intval($page_id))->get();
    }
}
