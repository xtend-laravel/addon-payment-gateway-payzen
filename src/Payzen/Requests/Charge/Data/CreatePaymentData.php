<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge\Data;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;

class CreatePaymentData extends Data
{
    public function __construct(
        #[Min(1), Max(12)]
        public int $amount,
        #[Min(3), Max(3)]
        public string $currency,
        #[Max(64)]
        public string $orderId,
        #[Max(128), Nullable]
        public ?string $contrib,
        #[Nullable]
        public ?CustomerData $customer,
    ) {
    }
}
