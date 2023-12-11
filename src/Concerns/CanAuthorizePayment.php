<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Concerns;

use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Transaction;

trait CanAuthorizePayment
{
    use CanReleasePayment;

    public function authorize(): PaymentAuthorize
    {
        // if ($this->order?->placed_at) {
        //     return new PaymentAuthorize(
        //         success: false,
        //         message: 'This order has already been placed',
        //     );
        // }

        $uuid = $this->data['payzen_order_id'] ?? null;
        if (! $uuid) {
            return new PaymentAuthorize(
                success: false,
                message: 'No Payzen Order ID found',
            );
        }

        $payload = new Transaction\Data\TransactionData(uuid: $uuid);
        $response = static::$payzen->send(
            request: new Transaction\Get(
                payload: $payload->toArray(),
            ),
        );

        $this->paymentIntent = $response->json('answer');

        if ($this->paymentIntent['status'] === 'RUNNING') {
            $payload = new Transaction\Data\TransactionData(uuid: $uuid);
            $response = static::$payzen->send(
                request: new Transaction\Validate(
                    payload: $payload->toArray(),
                ),
            );

            dd($response->json());
            $this->paymentIntent = static::$payzen->capturePaymentOrder($payzenOrderId);

            if ($this->paymentIntent['error'] ?? false) {
                return new PaymentAuthorize(
                    success: false,
                    message: collect($this->paymentIntent['error']['details'])->map(function ($detail) {
                        return $detail['description'].'=>'.$detail['issue'];
                    })->implode(' '),
                    orderId: $this->order->id,
                );
            }
            // @todo Handle errors

            $this->cart->update([
                'meta' => collect($this->cart->meta ?? [])->merge([
                    'payzen_payment_intent' => $this->paymentIntent['id'],
                ]),
            ]);
        }

        if (! $this->isPaymentIntentApproved()) {
            return new PaymentAuthorize(
                success: false,
                message: 'Payment not approved',
            );
        }

        return $this->releaseSuccess($this->paymentIntent);
    }

    protected function isPaymentIntentApproved(): bool
    {
        return in_array($this->paymentIntent['status'], [
            'COMPLETED',
            'APPROVED',
        ]);
    }
}
