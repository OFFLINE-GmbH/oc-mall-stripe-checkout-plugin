# Stripe Checkout for Mall

This plugin provides a Stripe Checkout payment gateway for Mall.

## Installation

1. Install the plugin via Composer:

```bash
composer require offline/oc-mall-stripe-checkout-plugin
```

1. Set your Stripe API key and Webhook secret in the Mall settings.
1. Configure a webhook in your Stripe dashboard with the target URL `https://your-site.com/mall/webhooks/stripe-checkout`. Subscribe to the `checkout.session.completed` and `checkout.session.async_payment_succeeded` events.
1. Configure a payment method to use the Stripe Checkout gateway.
