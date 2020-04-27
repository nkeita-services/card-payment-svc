<?php


namespace App\Providers\Infrastructure\Storage\Database\MongoDB;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Secrets\SecretManagerInterface;
use Infrastructure\Storage\Database\MongoDB\MongoClientInterface;
use MongoDB\Client;

class MongoDBClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MongoClientInterface::class, function ($app) {

            return $mongoClient = new Client(
                $app->make(SecretManagerInterface::class)->get('DB_MONGODB_URI')
            );

        });
    }
}
