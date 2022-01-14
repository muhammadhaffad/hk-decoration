<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // $this->app->bind(
        //     'App\Repositories\Penyewaan\IPenyewaanRepository',
        //     'App\Repositories\Penyewaan\PenyewaanRepository'
        // );

        // $this->app->bind(
        //     'App\Repositories\Dekorasi\IDekorasiRepository',
        //     'App\Repositories\Dekorasi\DekorasiRepository'
        // );
        Paginator::useBootstrap();
        Blade::directive('currency', function ( $expression ) { return "Rp. <?php echo number_format($expression,0,',','.'); ?>"; });
    }
}
