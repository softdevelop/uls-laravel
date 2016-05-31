<?php

namespace App\Providers;
use Blade;
use Illuminate\Support\ServiceProvider;
use Rowboat\CmsContent\Services\CmsContentService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('outject', function($expression) {
            preg_match('/\(\'(.*?)\',/', $expression, $match);
            if(empty($match[1])) return '';
            $variableName = $match[1];
            return "<?php \$$variableName = getObjectInfoAssets$expression; ?>";

        });

        Blade::directive('form', function($expression) {

            return "<?php echo renderForm(with{$expression}); ?>";
        });

        if(enableDebugbar()){
            \DB::connection('mongodb')->enableQueryLog();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
