<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FlutterwaveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('flutterwave', function () {
            return new \App\Services\Flutterwave([
                'publicKey' => config('services.flutterwave.public_key'),
                'secretKey' => config('services.flutterwave.secret_key'),
                'encryptionKey' => config('services.flutterwave.encryption_key'),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
