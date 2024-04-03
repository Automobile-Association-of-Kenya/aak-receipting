<?php

namespace App\Providers;

<<<<<<< HEAD
use App\Models\Payment;
use App\Observers\PaymentObsrver;
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
<<<<<<< HEAD
        Payment::observe(PaymentObsrver::class);
=======
        //
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
    }
}
