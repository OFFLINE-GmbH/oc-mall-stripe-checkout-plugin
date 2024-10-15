<?php

Route::post('/mall/webhooks/stripe-checkout', function () {
    $payload = @file_get_contents('php://input');
    $header = request()->header('Stripe-Signature');
    $event = null;

    try {
        $event = Stripe\Webhook::constructEvent(
            $payload,
            $header,
            decrypt(OFFLINE\Mall\Models\PaymentGatewaySettings::get('stripe_webhook_secret'))
        );
    } catch (UnexpectedValueException $e) {
        return response('Invalid payload', 400);
    } catch (Stripe\Exception\SignatureVerificationException $e) {
        return response('Invalid signature', 400);
    }

    if (in_array($event->type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'])) {
        try {
            $order = OFFLINE\MallStripeCheckout\classes\StripeCheckout::completeWebhook($event->data->object->id);
        } catch (Exception $e) {
            logger()->error('Stripe Checkout Webhook: ' . $e->getMessage(), ['event' => $event]);

            return response('Error processing webhook', 500);
        }

        logger()->info('Stripe Checkout Webhook: Order marked as paid', ['order' => $order->id]);
    }

    return response('Webhook received', 200);
});
