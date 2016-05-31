<?php namespace App\Listeners\Events;

use App\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Rowboat\Ticket\Services\CacheService;

class RouteEventHandler {

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
	public function handle($route, $request)
	{
		if(\Auth::user()) {
			if(!($request->wantsJson() || $route->getActionName() == 'Rowboat\Ticket\Http\Controllers\TicketController@getShow')){
				if(CacheService::has('filter_param_return_search_result_'.\Auth::user()->id)) {
					CacheService::forget('filter_param_return_search_result_'.\Auth::user()->id);
				}
			}			
		}
	}

}
