<?php namespace Rowboat\Notification\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rowboat\Notification\Models\Mongo\Notification;
use Rowboat\Ticket\Models\TicketModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
class NotificationController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

	public function getIndex(){
		$notificationModel = new Notification();
		return $notificationModel->getNotificationsOfUser(\Auth::user());
	}

	public function getAmountNotificationsNotRead(){
		$notificationModel = new Notification();
		$amount =  $notificationModel->getAmountNotificationsNotRead(\Auth::user());
		return array('result'=>$amount);
	}

    public function postSetRead()
    {
        $notificationModel = new Notification();
        return $notificationModel->setRead(\Auth::user());
    }

}
