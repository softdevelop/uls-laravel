<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Rowboat\Ticket\Models\TicketModel;
use App\Services\TimeService;
use Rowboat\Ticket\Models\TypeModel;
use App\Models\Mongo\DashboardModelMongo;
class DashboardController extends Controller
{
	/**
	 * Check email unique
	 *
	 * @return Response
	 */
	public function index()
	{
		$ticketModel = new TicketModel();
		$tickets_new = $ticketModel->getRequiredByMeTickets(\Auth::user());
		$tickets_allopen = $ticketModel -> getAllOpenTickets(\Auth::user());
		$states = $ticketModel::$states;
		return new JsonResponse(['tickets_new' => $tickets_new, 'tickets_allopen' => $tickets_allopen,'states'=>$states]);
	}

	public function setSessionFilterTicketType(Request $request)
	{
		$data = $request->all();

		session(['type_filter_'.\Auth::user()->id => $data['typeId']]);

		if($data['typeParent'] != null || $data['status'] != null || $data['typeId'] != null) {
			session(['is_show_all_'.\Auth::user()->id => true]);
		}

		if(isset($data['filterIncludeClosed']) && $data['filterIncludeClosed'] == true) {
			session(['filter_include_closed_'.\Auth::user()->id => true]);
		}

		if($data['status'] == null) {
			$data['status'] = '';
		}
		//  else {
		// 	session(['is_show_all_'.\Auth::user()->id => true]);
		// }
		session(['ticket_status_'.\Auth::user()->id => $data['status']]);
		
		return new JsonResponse(['status' => 1]);
	}

	public function selectTypeShow(Request $request)
	{
		$typeModel = new TypeModel();
		$data = $request->all();

		$type = $typeModel->find($data['typeId']);
		
		if($type) {
			$result = $type->RemoveExceptionTypeDashboard($type);
			return new JsonResponse(['status' => 1, 'type' => $result]);
		}
		return new JsonResponse(['status' => 0]);
	}

	/**
	 * remove type, don't show in dashboard
	 *
	 * @author Quang <quang@httsolution.com>
	 * 
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function removeTypeDashboard(Request $request)
	{
		$typeModel = new TypeModel();

		$data = $request->all();
		foreach ($data['types'] as $typeId) {
			$type = $typeModel->find($typeId);
			if($type != null) {
				$status = $type->createExceptionTypeDashboard();
			}
		}
		return new JsonResponse(['status' => 1]);
	}
	public function saveSort(Request $request) {
		$data = $request->all();
  		$status = DashboardModelMongo::editSortElement($data);
		return new JsonResponse(['status' => $status]);
	}

	public function changeCollapse(Request $request) 
	{
		$status = 0;

		$data = $request->all();
		$dashboardModelMongo = new DashboardModelMongo;

		$dashboard = $dashboardModelMongo->changeCollapse($data);
		
		if ($dashboard) {
			$status = 1;
		}

		return new JsonResponse(['status' => $status, 'dashboard' => $dashboard]);
	}
}
