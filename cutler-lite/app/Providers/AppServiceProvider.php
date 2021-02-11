<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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
        Carbon::now('Europe/Istanbul');
        setlocale(LC_TIME, 'Turkish');
        Schema::defaultStringLength(191);
        if(Schema::hasTable('settings')){
            $settings = Setting::find(1);
            view()->share('settings', $settings);
        }
        if(Schema::hasTable('languages')){
            $siteLanguages = Language::all();
            view()->share('siteLanguages', $siteLanguages);
        }
    }
}
