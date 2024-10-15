<?php

namespace OFFLINE\MallStripeCheckout;

use OFFLINE\Mall\Classes\Payments\DefaultPaymentGateway;
use OFFLINE\Mall\Classes\Payments\PaymentGateway;
use OFFLINE\MallStripeCheckout\classes\StripeCheckout;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    public $require = [
        'OFFLINE.Mall',
    ];

    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Stripe Checkout for Mall',
            'description' => 'Adds Stripe Checkout to the Mall plugin.',
            'author' => 'OFFLINE',
            'icon' => 'icon-credit-card',
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        $this->app->singleton(PaymentGateway::class, function () {
            $gateway = new DefaultPaymentGateway();
            $gateway->registerProvider(new StripeCheckout());

            return $gateway;
        });
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }
}
