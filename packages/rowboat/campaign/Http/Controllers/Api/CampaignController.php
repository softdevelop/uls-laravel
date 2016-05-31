<?php namespace Rowboat\Campaign\Http\Controllers\Api;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Rowboat\Campaign\Models\CampaignModel;
use Rowboat\Campaign\Services\TimeService;
use App\Http\Controllers\Controller;
use Redis;

class CampaignController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Campaign Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function searchReportCampaign(Request $request)
    {
        /* Get all data request */
        $data = $request->all();

        /* Current user login */
        $user = \Auth::user();

        /* Format date with time zone */
        $data['startDate'] = TimeService::setTimeZoneCurrentUser($user->time_zone, $data['start_date']);
        $data['endDate'] = TimeService::setTimeZoneCurrentUser($user->time_zone, $data['end_date']);
        
        /* Init campaign model to call function it it */
        $campaignModel = new CampaignModel;

        /* dateRange*/
        $dateRange = $campaignModel->createDateRangeArray($data['startDate'], $data['endDate']);

        /* Get report campaign by date range */
        $dataReportChart = $campaignModel->getGraphReportGroupByDate($dateRange, 'campaign');
        $campaigns = $campaignModel->reportCampaign;
        $total = $campaignModel->rowTotal;
        $labels = $campaignModel->getKeys('campaign');

        return new JsonResponse(['campaigns'=>$campaigns, 'total'=>$total, 'dateRange' => $dateRange, 'dataReportChart' => $dataReportChart]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function searchReportAds(Request $request)
    {
        $data = $request->all();
        $type = 'ads';

        /* Current user login */
        $user = \Auth::user();
        
        /* Format date with time zone */
        $data['startDate'] = TimeService::setTimeZoneCurrentUser($user->time_zone, $data['start_date']);
        $data['endDate'] = TimeService::setTimeZoneCurrentUser($user->time_zone, $data['end_date']);

        /* Init campaign model to call function it it */
        $campaignModel = new CampaignModel;

        /* dateRange*/
        $dateRange = $campaignModel->createDateRangeArray($data['startDate'], $data['endDate']);

        /* Get report ads by date range */
        $dataReportChart = $campaignModel->getGraphReportGroupByDate($dateRange, $type, $data);
        $campaigns = $campaignModel->reportAds;
        $total = $campaignModel->rowTotal;
        $labels = $campaignModel->getKeys('ads');

        return new JsonResponse(['campaigns'=>$campaigns, 'labels'=>$labels, 'total'=>$total, 'dateRange' => $dateRange, 'dataReportChart' => $dataReportChart]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function searchReportGroup(Request $request)
    {
        $data = $request->all();
        $type = 'group-report';

        /* Current user login */
        $user = \Auth::user();
        
        /* Format date with time zone */
        $data['startDate'] = TimeService::setTimeZoneCurrentUser($user->time_zone, $data['start_date']);
        $data['endDate'] = TimeService::setTimeZoneCurrentUser($user->time_zone, $data['end_date']);

        /* Init campaign model to call function it it */
        $campaignModel = new CampaignModel;

        /* dateRange*/
        $dateRange = $campaignModel->createDateRangeArray($data['startDate'], $data['endDate']);

        /* Get report group by date range */
        $dataReportChart = $campaignModel->getGraphReportGroupByDate($dateRange, $type, $data);
        $campaigns = $campaignModel->reportGroup;
        $total = $campaignModel->rowTotal;
        $labels = $campaignModel->getKeys('group-report');

        return new JsonResponse(['campaigns'=>$campaigns, 'labels'=>$labels, 'total'=>$total, 'dateRange' => $dateRange, 'dataReportChart' => $dataReportChart]);
    }
   
}
