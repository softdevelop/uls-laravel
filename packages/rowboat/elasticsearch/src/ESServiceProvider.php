<?php 
namespace Rowboat\ES;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
/**
 * Class ElasticsearchServiceProvider
 *
 * ServiceProvider compatible with Laravel 5
 *
 * @package Shift31\LaravelElasticsearch
 */
class ESServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Elasticsearch\Client', function () {
            $connParams = array();
            $connParams['hosts'] = [env('url_elastic_search', 'localhost:9200')];
            $connParams['logPath'] = storage_path() . '/logs/elasticsearch.log';
            $connParams['logLevel'] = Logger::INFO;
            // merge settings from app/config/elasticsearch.php
            $params = array_merge($this->app['config']->get('elasticsearch', array()), $connParams);
            

            $logger = ClientBuilder::defaultLogger($params['logPath']);

            $client = ClientBuilder::create()
            ->setHosts($params['hosts'])
            ->build();

            return $client;
            return new Client($params);
        });

        $this->app->alias('Elasticsearch\Client', 'elasticsearch');

        $this->app->alias('Elasticsearch\Client', 'elasticsearch');
        $this->app->alias('Rowboat\ES\Services\ElasticSearchService', 'EsService');

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('RES', 'Rowboat\ES\Facades\RES');
            $loader->alias('EsService', 'Rowboat\ES\Facades\ESS');
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['elasticsearch', 'Elasticsearch\Client'];
    }
}
