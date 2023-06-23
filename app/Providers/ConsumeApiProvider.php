<?php 

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ConsumeApiProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind('consume-api', function() {
            return Http::withOptions([
                'verify' => false,
                'base_uri' => "https://dev.gosat.org/api/v1/simulacao/",
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}