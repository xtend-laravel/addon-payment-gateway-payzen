<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen;

use Binaryk\LaravelRestify\Traits\InteractsWithRestifyRepositories;
use CodeLabX\XtendLaravel\Base\XtendAddonProvider;
use Lunar\Facades\Payments;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Xtend\Extensions\Lunar\Core\Concerns\XtendLunarCartPipeline;
use XtendLunar\Addons\PaymentGatewayPayzen\Base\PayzenConnectInterface;
use XtendLunar\Addons\PaymentGatewayPayzen\Base\PayzenPayment;
use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\PayzenApiConnector;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;

class PaymentGatewayPayzenProvider extends XtendAddonProvider
{
    use InteractsWithRestifyRepositories;
    use XtendLunarCartPipeline;

    public function register()
    {
        $this->loadRestifyFrom(__DIR__.'/Restify', __NAMESPACE__.'\\Restify\\');
        $this->mergeConfigFrom(__DIR__.'/../config/payzen.php', 'payzen');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/payzen.php' => config_path('payzen.php'),
        ]);

        $this->app->singleton(PayzenConnectInterface::class, function () {
            return new PayzenApiConnector(
                username: config('payzen.username'),
                password: config('payzen.mode') === 'test'
                    ? config('payzen.test_password')
                    : config('payzen.production_password'),
            );
        });

        Payments::extend('payzen', function ($app) {
            return $app->make(PayzenPayment::class);
        });

        PaymentGateway::query()->updateOrCreate([
            'driver' => 'payzen',
        ], [
            'name' => 'PayZen',
            'is_enabled' => true,
        ]);
    }
}
