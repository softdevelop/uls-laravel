<?php
namespace Rowboat\TagContent;

use Illuminate\Support\ServiceProvider;
use Rowboat\TagContent\Commands\InstallCommand;

class TagContentServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }

        $this->loadViewsFrom(__DIR__.'/views', 'tag-content');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor'),
        ], 'resource');

        $this->publishes([
            __DIR__.'/public/components' => base_path('public/app/components'),
        ], 'html');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // include __DIR__.'/routes.php';
        // $this->app->make('Rowboat\Campaign\Http\Controllers\CampaignController');

        foreach (glob(__DIR__.'/Helpers/*.php')  as $filename){
            require_once($filename);
        }
    }

}
