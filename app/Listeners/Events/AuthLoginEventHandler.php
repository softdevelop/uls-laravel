<?php namespace App\Listeners\Events;

use App\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Rowboat\Users\Models\UserModel;
class AuthLoginEventHandler {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  Events  $event
	 * @return void
	 */
	public function handle(UserModel $user)
	{
		$user->last_login = date('Y-m-d H:i:s');
		$user->time_zone = !empty($_COOKIE['time-zone-user']) ? $_COOKIE['time-zone-user'] : 0;
		$user->save();
	}

}
