<?php 
namespace Rowboat\Campaign\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Rowboat\Campaign\Models\CampaignModel;
use App\Services\TimeService;
use Illuminate\Support\Facades\Redis;

class CampaignController extends Controller {

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
	 * Display a listing of the campaign.
	 *
	 * @return Response
	 */
	public function index()
	{
		$campaignModel = new CampaignModel;

		//get Campaign Report
		$endDate   = date("Y-m-d", strtotime("-1 day"));
		$startDate = date('Y-m-d', strtotime("-7 day"));
		$dateRange = $campaignModel->createDateRangeArray($startDate, $endDate);
		$dataReportChart = $campaignModel->getGraphReportGroupByDate($dateRange, 'campaign');
		$campaigns = $campaignModel->reportCampaign;
		$total = $campaignModel->rowTotal;
		$labels = $campaignModel->getKeys('campaign');
		
		return view('campaign::index', compact('campaigns', 'total', 'dateRange', 'dataReportChart', 'endDate', 'startDate'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		abort(404);
	}

	/**
	 * Report Ads Group
	 * @param  int $id campaignID
	 * @return Respone     
	 */
	public function reportGroup($campaignId)
	{
		$campaignModel = new CampaignModel;
		//get Ads Report
		$data = array();
		$data['campaignId'] = $campaignId;
		$endDate = date("Y-m-d", strtotime("-1 day"));
		$startDate = date('Y-m-d', strtotime("-7 day"));
		$dateRange = $campaignModel->createDateRangeArray($startDate, $endDate);
		$dataReportChart = $campaignModel->getGraphReportGroupByDate($dateRange, 'group-report', $data);
		$campaigns = $campaignModel->reportGroup;
		$total = $campaignModel->rowTotal;
		$labels = $campaignModel->getKeys('group-report');
		$campaignName = $campaignModel->campaignName;

		return view('campaign::report-group', compact(
			'campaigns', 'labels', 'total', 
			'campaignId', 'dataReportChart', 'dateRange',
			 'endDate', 'startDate',
			 'campaignName', 'groupName'
			 )
		);
	}

	/**
	 * Report ads
	 * @param  int $id groupID
	 * @return Respone     
	 */
	public function reportAds($groupId)
	{
		$campaignModel = new CampaignModel;
		//get Ads Report
		$data = array();
		$data['groupId'] = $groupId;
		$endDate = date("Y-m-d", strtotime("-1 day"));
		$startDate = date('Y-m-d', strtotime("-7 day"));
		$dateRange = $campaignModel->createDateRangeArray($startDate, $endDate);
		$dataReportChart = $campaignModel->getGraphReportGroupByDate($dateRange, 'ads', $data);
		$campaigns = $campaignModel->reportAds;
		$total = $campaignModel->rowTotal;
		$labels = $campaignModel->getKeys('ads');
		$campaignName = $campaignModel->campaignName;
		$groupName = $campaignModel->groupName;
		$campaignId = $campaignModel->campaignId;
		return view('campaign::report-ads', compact(
			'campaigns', 'labels', 'total', 
			'groupId', 'dataReportChart', 
			'dateRange', 'endDate', 'startDate',
			'campaignName', 'groupName', 'campaignId'
			));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	}

	public function deleteCacheCampaign()
	{
		Redis::flushall();die('done');
	}
}
