<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Concerns;

use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\PayzenApiConnector;
use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge\CreatePayment;
use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge\Data\CreatePaymentData;
use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge\Data\CustomerBillingData;
use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge\Data\CustomerData;

trait WithCreatePayment
{
    protected static PayzenApiConnector $payzen;

    public function create(): mixed
    {
        $payload = new CreatePaymentData(
            amount: $this->cart->total->value,
            currency: $this->cart->currency->code ?? 'EUR',
            orderId: 'cart-'.$this->cart->id,
            contrib: 'laravel-payment-gateway-payzen',
            customer: new CustomerData(
                reference: 'customer-'.$this->cart->customer->id,
                email: $this->cart->user->email,
                billing: new CustomerBillingData(
                    firstName: $this->cart->billingAddress->first_name,
                    lastName: $this->cart->billingAddress->last_name,
                    address: collect([
                        $this->cart->billingAddress->line_one,
                        $this->cart->billingAddress->line_two,
                        $this->cart->billingAddress->city,
                        $this->cart->billingAddress->postcode,
                        $this->cart->billingAddress->state,
                    ])->filter()->join(' '),
                    country: $this->cart->billingAddress->country->iso2,
                ),
            ),
        );

        $payzenOrder = static::$payzen->send(
            request: new CreatePayment(
                payload: $payload->toArray(),
            ),
        );

        if ($payzenOrder->successful()) {
            $response = $payzenOrder->json('answer');
            $this->addPayzenMetaDataToCart($response);
            return [
                'formToken' => $response['formToken'],
            ];
        }

        return [
            'error' => $payzenOrder->json(),
        ];
    }

    protected function addPayzenMetaDataToCart(array $response): void
    {
        // $this->cart->update([
        //     'meta' => collect($cart->meta ?? [])->merge([
        //         'payzen_form_token' => $response['formToken'],
        //         'payzen_order_id' => $response['order']['id'],
        //         'paypal_client_token' => $clientToken ?? static::$paypal->getClientToken()['client_token'],
        //     ]),
        // ]);
    }
}
