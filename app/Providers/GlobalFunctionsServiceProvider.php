<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Auth;
class GlobalFunctionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $now = Carbon::now();
        View::share('api_url', env('API_URL'));
        View::share('year_now', $now->year);
        View::share('month_now', (string)$now->month);
        View::share('initial_date', $now->format('Y-m-d'));
        View::share('irene_base_url',URL::to('/'));
        View::share('irene_api_base_url',URL::to('/').'/api');
        View::share('idletime', 600);
        View::share('url_history', 'http://192.168.0.240:81/history2');
    }
}
