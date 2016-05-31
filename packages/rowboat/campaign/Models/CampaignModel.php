<?php 
namespace Rowboat\Campaign\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class CampaignModel extends Model
{
    protected $_result;

    /* Contain keys of campaign, ads and report*/
    protected $keysCampaign = [];
    protected $keysAds = [];
    protected $keysGroup = [];

    /* Contain total data report */
    protected $totalReport = [];

    /* Contain row total of report */
    public $rowTotal = [];

    /* Array contain report of campaign, group and ads */
    public $reportCampaign = [];
    public $reportGroup = [];
    public $reportAds = [];

    /* Name of campaign */
    public $campaignName = '';

    /* Name of group */
    public $groupName = '';

    /* Set default value for campaignId and groupId */
    public $campaignId = 0;
    public $groupId = 0;
    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct();
        define('SRC_PATH', app_path().'/../vendor/googleads/googleads-php-lib/src/');
        define('LIB_PATH', 'Google/Api/Ads/AdWords/Lib');
        define('UTIL_PATH', 'Google/Api/Ads/Common/Util');
        define('ADWORDS_UTIL_PATH', 'Google/Api/Ads/AdWords/Util');
        define('ADWORDS_UTIL_VERSION_PATH', 'Google/Api/Ads/AdWords/Util/v201509');
        define('ADWORDS_VERSION', 'v201509');

        // Configure include path
        ini_set('include_path', implode(array(
            ini_get('include_path'), PATH_SEPARATOR, SRC_PATH
        )));

        // Include the AdWordsUser
        require_once LIB_PATH . '/AdWordsUser.php';
        require_once ADWORDS_UTIL_VERSION_PATH . '/ReportUtils.php';

    }

    /**
     * get Campaign Report
     * @return Array Campaign Report
     */
    public function getReportCampaign($date = null)
    {
        /* Check cache search campaing or show chart if date != null (when search report & chart campaign by date range) */
        if (!is_null($date)) {
            /* Format date for calculator */
            $date = date("Ymd", strtotime($date));
            /* get cache of campaign report */
            $searchCampaignCache = Redis::get('campaign_'. $date);
            /* If isset cache of report*/
            if ($searchCampaignCache) {
                /* Set cache for result */
                $this->_result = json_decode($searchCampaignCache);
                /* Format result to show data in view */
                $this->cleanResultFromApiReport('campaign');

                return $this->_result;
            }
        }
        
        $user = new \AdWordsUser(config_path().'/adword.ini', null, null,  null, config_path().'/adword.ini');
        /* Log every SOAP XML request and response. */
        $user->LogAll();
        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);

        $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);

        // $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
        /* Create selector. */
        $selector = new \Selector();
        $selector->fields = array('CampaignId', 'CampaignName',  'Impressions', 'Clicks',
                                  'ConvertedClicks', 'AverageCpc', 'ClickConversionRate',
                                  'AveragePosition', 'CampaignStatus', 'Ctr', 'Cost');
        /* If date input != null */
        $selector->dateRange = ['min' => date('Ymd', strtotime($date)), 'max' => date('Ymd', strtotime($date))];
        /* Create report definition. */
        $reportDefinition = new \ReportDefinition();
        $reportDefinition->selector = $selector;
        $reportDefinition->reportName = 'Criteria performance report #' . uniqid();
        $reportDefinition->dateRangeType = 'CUSTOM_DATE';
        $reportDefinition->reportType = 'CAMPAIGN_PERFORMANCE_REPORT';
        $reportDefinition->downloadFormat = 'CSV';
        /* Set additional options. */
        $options = array('version' => ADWORDS_VERSION);
        /* Download report. */
        $this->_result = \ReportUtils::DownloadReport($reportDefinition, null, $user, $options);
        /* Add report into cache when $date smaller current date. */
        if ($date < date('Ymd')) {
            Redis::set('campaign_'.$date, json_encode($this->_result));
        }
        /* Format result to show data in view */
        $this->cleanResultFromApiReport('campaign');

        return $this->_result;
    }

    /**
     * get ReportAds
     * @param  string $id 
     * @return array    
     */
    public function getReportAdsAndGroup($typeReport = null, $id, $date = null)
    {
        /* Check cache search ads or show chart if date != null (when search report & chart ads by date range) */
        if (!is_null($date)) {
            /* Get cache of ads report */
            $searchAdsAndGroupCache = Redis::get($typeReport . $id .'_'. $date);
            /* If isset cache of report and date must smaller current date */
            if ($searchAdsAndGroupCache &&  $date < date('Ymd')) {
                /* Set cache for result */
                $this->_result = json_decode($searchAdsAndGroupCache);
                /* Format result to show data for view */
                $this->cleanResultFromApiReport($typeReport);
                return $this->_result;
            }
        }
        
        $user = new \AdWordsUser(config_path().'/adword.ini', null, null,  null, config_path().'/adword.ini');
        /* Log every SOAP XML request and response. */
        $user->LogAll();
        $campaignService = $user->GetService('CampaignService', ADWORDS_VERSION);
        $user->LoadService('ReportDefinitionService', ADWORDS_VERSION);
        /* If user search report for Ads */
        if ($typeReport == 'ads') {
            /* Create selector. */
            $selector = new \Selector();
            $selector->fields = array('CampaignName', 'AdGroupName', 'CampaignStatus', 'Clicks',
                                      'Impressions', 'Ctr', 'AverageCpc', 'AveragePosition',
                                      'Headline', 'ConvertedClicks', 'ViewThroughConversions', 'AdGroupId', 'CampaignId', 'Cost');
            /* Optional: use predicate to filter out paused criteria. */
            $selector->predicates[] = new \Predicate('AdGroupId', 'IN', array($id));
        } else {
            /* Create selector. */
            $selector = new \Selector();
            $selector->fields = array('CampaignName', 'AdGroupName', 'CampaignStatus', 'Clicks',
                                      'Impressions', 'Ctr', 'AverageCpc', 'AveragePosition',
                                      'ConvertedClicks', 'ViewThroughConversions', 'AdGroupId', 'Cost');
            /* Optional: use predicate to filter out paused criteria. */
            $selector->predicates[] = new \Predicate('CampaignId', 'IN', array($id));
        }
         /* If date input != null */
        $selector->dateRange = ['min' => date('Ymd', strtotime($date)), 'max' => date('Ymd', strtotime($date))];
        /* Create report definition. */
        $reportDefinition = new \ReportDefinition();
        $reportDefinition->selector = $selector;
        $reportDefinition->reportName = 'Criteria performance report #' . uniqid();
        $reportDefinition->dateRangeType = 'CUSTOM_DATE';
       /* If user search report for Ads */
        if ($typeReport == 'ads') {
            $reportDefinition->reportType = 'AD_PERFORMANCE_REPORT';
        } else {
            $reportDefinition->reportType = 'ADGROUP_PERFORMANCE_REPORT';
        }
        $reportDefinition->downloadFormat = 'CSV';
        /* Set additional options. */
        $options = array('version' => ADWORDS_VERSION);
        /* Download report. */
        $this->_result = \ReportUtils::DownloadReport($reportDefinition, null, $user, $options);

        /* check type search. */
        if ($date < date('Ymd')) {
            Redis::set($typeReport . $id . '_' . $date, json_encode($this->_result));
        }

        $this->cleanResultFromApiReport($typeReport);

        return $this->_result;
    }
   
    /**
     * get campaign report group by day
     * @return [array] return data is used for chart
     */
    public function getGraphReportGroupByDate($dateRange, $type, $dataInput = null)
    {
        /**
         * List label to map data report
         * [Clicks] => 0
         * [Impressions] => 0
         * [Converted clicks] => 0
         * [CTR] => 0
         * [Avg. CPC] => 0
         * [CPA] => 0
        */
       
        /* Array contain data to show chart report for campaign and ads */
        $resultReportCampaignGroupByDay = [];

        /* $items contain list data is got from report api adwords */
        $resultReportCampaignGroupByDay = [
            'Clicks'      => ['name' => 'Clicks', 'data' => []],
            'Impressions' => ['name' => 'Impressions', 'data' => []],
            'Conversions'  => ['name' => 'Conversions', 'data' => []],
            'CTR'         => ['name' => 'CTR', 'data' => []],
            'Avg. CPC'    => ['name' => 'Avg. CPC', 'data' => []],
            'CPA'         => ['name' => 'CPA', 'data' => []],
            'Avg. Position' => ['name' => 'Avg. Position', 'data' => []],
        ];

        /* Array contain data of row total */
        $total = ['Clicks' => 0, 'Impressions' => 0, 'Conversions' => 0, 'CTR' => 0, 'AvgCPC' => 0, 'CPA' => 0, 'Avgposition' => 0, 'Cost' => 0];
        
        /* For list day input to get google api report campaigns, ads and groups */
        foreach ($dateRange as $key => $value) {
            $data = ['Clicks' => 0, 'Impressions' => 0, 'Conversions' => 0, 'CTR' => 0, 'Avg. CPC' => 0, 'CPA' => 0, 'Avg. Position' => 0, 'Cost' => 0];
            
            /* If type of data input is campaign */
            if ($type == 'campaign') {
                
                /* Call function to get report campaign */
                $this->getReportCampaign($value);

                /* Each result */
                foreach ($this->_result as $key => $value) {

                    /* Call function to plus data report of campaign */
                    $this->plusDataReport($this->reportCampaign, $value, $type);

                    /* Calculate total report of campaign in data dateRange input to show in chart */
                    $data['Clicks']      += $value[$this->keysCampaign['Clicks']];
                    $data['Cost']        += $value[$this->keysCampaign['Cost']];
                    $data['Impressions'] += $value[$this->keysCampaign['Impressions']];
                    $data['Conversions']  += $value[$this->keysCampaign['Converted clicks']];
                    $data['CTR']         += $value[$this->keysCampaign['CTR']];
                    $data['Avg. CPC']    = ($data['Clicks'] != 0) ? round(($data['Conversions'] / $data['Clicks']), 5) : 0;
                    $data['CPA']         = ($data['Conversions'] != 0) ? round(($data['Cost']  / $data['Conversions']), 5) : 0;
                    $data['Avg. Position'] += $value[$this->keysCampaign['Avg. position']];
                }
            }
            /* If type of data input is ads */
            elseif ($type == 'ads') {
                /* Call function to get report Ads and Groups */
                $this->getReportAdsAndGroup($type, $dataInput['groupId'], $value);

                /* Each result data */
                foreach ($this->_result as $key => $value) {
                    /* Set campaign name */
                    $this->campaignName =  $value[$this->keysAds['Campaign']];
                    /* Set group name */
                    $this->groupName =  $value[$this->keysAds['Ad group']];
                    /* Set campaign id */
                    $this->campaignId =  $value[$this->keysAds['Campaign ID']];

                    /* Call function to plus data report of Ads */
                    $this->plusDataReport($this->reportAds, $value, $type);

                    /* Calculate total report of ads in data dateRange input to show in chart */
                    $data['Clicks']      += $value[$this->keysAds['Clicks']];
                    $data['Cost']        += $value[$this->keysAds['Cost']];
                    $data['Impressions'] += $value[$this->keysAds['Impressions']];
                    $data['Conversions']  += $value[$this->keysAds['Converted clicks']];
                    $data['CTR']         += $value[$this->keysAds['CTR']];
                    $data['Avg. CPC']    = ($data['Clicks'] != 0) ? round(($data['Conversions'] / $data['Clicks']), 5) : 0;
                    $data['CPA']         = ($data['Conversions'] != 0) ? round(($data['Cost'] / $data['Conversions']), 5) : 0;
                    $data['Avg. Position'] += $value[$this->keysAds['Avg. position']];
                }
            }
            /* If type of data input is group-report */
            elseif ($type == 'group-report') {
                /* Call function to get report Ads and Groups */
                $this->getReportAdsAndGroup($type, $dataInput['campaignId'], $value);
                    
                    /* Each result data */
                    foreach ($this->_result as $key => $value) {
                        /* Set campaign name */
                        $this->campaignName =  $value[$this->keysGroup['Campaign']];

                        /* Call function to plus data report of Ads */
                        $this->plusDataReport($this->reportGroup, $value, $type);

                        /* Calculate total report of group in data dateRange input to show in chart */
                        $data['Clicks']      += $value[$this->keysGroup['Clicks']];
                        $data['Cost']        += $value[$this->keysGroup['Cost']];
                        $data['Impressions'] += $value[$this->keysGroup['Impressions']];
                        $data['Conversions']  += $value[$this->keysGroup['Converted clicks']];
                        $data['CTR']         += $value[$this->keysGroup['CTR']];
                        $data['Avg. CPC']    = ($data['Clicks'] != 0) ? round(($data['Conversions'] / $data['Clicks']), 5) : 0;
                        $data['CPA']         = ($data['Conversions'] != 0) ? round(($data['Cost'] / $data['Conversions']), 5) : 0;
                        $data['Avg. Position'] += $value[$this->keysGroup['Avg. position']];
                    }
            }

            /* Calculate total report of field */
            $total['Clicks']      += $data['Clicks'];
            $total['Cost']        += $data['Cost'];
            $total['Impressions'] += $data['Impressions'];
            $total['Conversions']  += $data['Conversions'];
            $total['CTR']         += $data['CTR'];
            $total['AvgCPC']      =  ($total['Clicks']) ? round(($total['Conversions'] / $total['Clicks']), 5) : 0;
            $total['CPA']         = ($total['Conversions']) ? round(($total['Cost'] / $total['Conversions']), 5) : 0;
            $total['Avgposition'] += $data['Avg. Position'];

            // d($data);die;
            // d($data);die;
            foreach ($data as $key => $value) {
                $resultReportCampaignGroupByDay[$key]['data'][] = $data[$key];
            }
            // unset($resultReportCampaignGroupByDay['Avg. Position']);
        }
        /* Call function plus total report */
        $this->rowTotal = $total;

        return array_values($resultReportCampaignGroupByDay);
    }

    /**
     * Plus index data report
     * @param  Array data  data sum report
     * @param  Array $value data report
     * @param  string $type type of report
     * @return Array        Aray sum report
     */
    public function plusDataReport(&$data, $value, $type)
    {
        switch ($type) {
            case 'campaign':
                $key = $value[0];
            break;

            case 'group-report':
                 $key = $value[10];
            break;

            default:
                $key = $value[12];
            break;
        }

        /* If not exists array of id report then declare new array with key report*/
        if (empty($data[$key])) {
            /* Set array */
            $data[$key] =  [
                'Clicks' => 0, 'Impressions' => 0,
                'Conversions' => 0, 'CTR' => 0, 'AvgCPC' => 0,
                'CPA' => 0, 'Avgposition' => 0, 'Cost' => 0
            ];
            /* Set name */
            $data[$key]['name'] = $value[1];
        }

        /* Plus total of report with field Clicks, Impressions, Conversions, CTR... */
        $data[$key]['Clicks']      += $value[$this->getKeys($type)['Clicks']];
        $data[$key]['Cost']        += $value[$this->getKeys($type)['Cost']];
        $data[$key]['Impressions'] += $value[$this->getKeys($type)['Impressions']];
        $data[$key]['Conversions']  += $value[$this->getKeys($type)['Converted clicks']];
        $data[$key]['CTR']         += $value[$this->getKeys($type)['CTR']];
        $data[$key]['AvgCPC']      = ($data[$key]['Clicks'] != 0) ? round(($data[$key]['Conversions'] / $data[$key]['Clicks']), 5) : 0;
        $data[$key]['CPA']         = ($data[$key]['Conversions'] != 0) ? round(($data[$key]['Cost'] / $data[$key]['Conversions']), 5) : 0;
        $data[$key]['Avgposition'] += $value[$this->getKeys($type)['Avg. position']];
    }

    /**
     * set Keys label map to get data
     * @param string $type   type of report
     * @param array $fields  array label
     */
    protected function _setKeys($type, $fields)
    {
        switch ($type) {
            case 'campaign':
                if (empty($this->keysCampaign)) {
                    $this->keysCampaign = array_flip($fields);
                }
                break;

            case 'ads':
                if (empty($this->keysAds)) {
                    $this->keysAds = array_flip($fields);
                }
                break;

            case 'group-report':
                if (empty($this->keysGroup)) {
                    $this->keysGroup = array_flip($fields);
                }
                break;
        }
    }

    /**
     * return keys follow type report
     * @param  [type] $type  is campaign or ad
     * @return [array]       list columns header
    */
    public function getKeys($type)
    {
        switch ($type) {
            case 'campaign':
                return $this->keysCampaign;
                break;

            case 'ads':
                return $this->keysAds;
                break;

            case 'group-report':
                return $this->keysGroup;
                break;
        }
    }
   
    /**
    * convert data report to array
    * @param  string $type is campaign or ad
    * @return null
    */
    protected function cleanResultFromApiReport($type = 'campaign')
    {
        $this->_result = explode("\n", $this->_result);
        $this->_result = array_map('str_getcsv', $this->_result);

        // unset header
        array_splice($this->_result, 0, 1);

        $this->_setKeys($type, $this->_result[0]);

        // unset header column
        array_splice($this->_result, 0, 1);

        // unset row empty
        array_splice($this->_result, -1, 1);

        // unset row total
        array_splice($this->_result, -1, 1);
        // add data for column CPA
    }

    /**
     * get all date in range day input
     * @param  date $strDateFrom start date of array day
     * @param  date $strDateTo   end date of array day
     * @return Array             array day result
     */
    public function createDateRangeArray($strDateFrom, $strDateTo)
    {
        $aryRange = array();

        /* First day */
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        /* End day */
        $iDateTo   = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
        /* If End day bigger Start day */
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y/m/d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y/m/d', $iDateFrom));
            }
        }
        return $aryRange;
    }
}
