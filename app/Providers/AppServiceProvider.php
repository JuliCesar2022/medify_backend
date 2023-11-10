<?php

namespace App\Providers;

use App\Http\Repositories\Epayco\Contracts\EpaycoContract;
use App\Http\Repositories\Epayco\EpaycoRepository;
use Illuminate\Support\ServiceProvider;
use Epayco\Epayco;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EpaycoContract::class, function () {
            $epayco = new Epayco(
                array(
                    "apiKey" => env("EPAYCO_API_KEY"),
                    "privateKey" => env("EPAYCO_PRIVATE_KEY"),
                    "lenguage" => "ES",
                    "test" => true
                )
            );
            return new EpaycoRepository($epayco);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
