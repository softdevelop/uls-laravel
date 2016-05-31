<?php namespace Rowboat\Notification;

use Illuminate\Support\ServiceProvider;
use Rowboat\Notification\Commands\InstallCommand;
class NotificationServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/views', 'notification');

		$this->publishes([
		    __DIR__.'/../public/shared' => public_path('app/shared'),
		], 'public');

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		include __DIR__.'/routes.php';
		$this->app->make('Rowboat\Notification\Http\Controllers\Api\NotificationController');
	}


}
