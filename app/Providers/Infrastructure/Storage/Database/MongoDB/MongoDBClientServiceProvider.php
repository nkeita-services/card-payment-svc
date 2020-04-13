<?php


namespace App\Providers\Infrastructure\Storage\Database\MongoDB;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Storage\Database\MongoDB\MongoClientInterface;
use MongoDB\Client;

class MongoDBClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MongoClientInterface::class, function ($app) {

            return $mongoClient = new Client(
                'mongodb+srv://wallet-account-user:ccKUENpgY2Bj0gly@cluster0-ydv8p.mongodb.net/wallet?authSource=admin'
            );

        });
    }
}
