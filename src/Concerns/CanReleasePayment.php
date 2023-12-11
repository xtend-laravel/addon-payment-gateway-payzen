<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Concerns;

use Lunar\Base\DataTransferObjects\PaymentAuthorize;

trait CanReleasePayment
{
    /**
     * Return a successfully released payment.
     *
     * @return void
     */
    private function releaseSuccess(array $payzenOrder): PaymentAuthorize
    {
        $transactions = collect();

        foreach ($payzenOrder['purchase_units'] as $purchaseUnit) {
            foreach ($purchaseUnit['payments']['captures'] ?? [] as $capture) {
                $transactions->push(
                    [
                        'success' => $capture['status'] == 'COMPLETED',
                        'type' => 'capture',
                        'driver' => 'payzen',
                        'amount' => (int) ($capture['amount']['value'] * 100),
                        'reference' => $capture['id'],
                        'status' => $capture['status'] === 'COMPLETED' ? 'succeeded' : 'failed',
                        'card_type' => 'payzen',
                        'captured_at' => now()->parse($capture['create_time']),
                    ]
                );
            }
        }

        $this->order->transactions()->createMany($transactions);

        $this->order->update([
            'status' => $this->config['released'] ?? 'payment-received',
            'placed_at' => now(),
        ]);

        return new PaymentAuthorize(
            success: true,
            message: 'Payment successfully received',
            orderId: $this->order->id,
        );
    }
}
