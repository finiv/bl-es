<?php

namespace App\Providers;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            $logger = new Logger('elasticsearch');
            $logger->pushHandler(new StreamHandler(storage_path('logs/elasticsearch.log'), Logger::DEBUG));

            return ClientBuilder::create()
                ->setHosts([env('ELASTICSEARCH_HOST', 'https://localhost:9200')])
                ->setBasicAuthentication(env('ELASTICSEARCH_USERNAME', 'elastic'), env('ELASTICSEARCH_PASSWORD'))
                ->setSSLVerification(false)
                ->setLogger($logger)
                ->build();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
