<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use EasyWeChat\Factory;
use App\CacheBridge;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('wechat',function(){
            $options = config('wechat');
            $app =  Factory::officialAccount($options);
            $app->rebind('cache', new CacheBridge());
            return $app;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
