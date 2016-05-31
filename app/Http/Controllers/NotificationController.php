<?php namespace App\Http\Controllers;

use Rowboat\Notification\Models\Mongo\Notification;

class NotificationController extends Controller {

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$notificationModel = new Notification();
		$notifications = $notificationModel->getNotificationsOfUser(\Auth::user());
		return view('notification.viewall',compact('notifications'));
	}
}
