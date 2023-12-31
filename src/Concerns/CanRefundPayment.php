<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Concerns;

use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Models\Transaction;

trait CanRefundPayment
{
    public function refund(Transaction $transaction, int $amount = 0, $notes = null): PaymentRefund
    {
        return new PaymentRefund(true);
    }
}
