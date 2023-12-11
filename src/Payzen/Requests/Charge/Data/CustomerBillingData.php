<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge\Data;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class CustomerBillingData extends Data
{
    public function __construct(
        #[Max(63)]
        public string $firstName,
        #[Max(63)]
        public string $lastName,
        #[Max(255)]
        public string $address,
        #[Min(2), Max(2)]
        public string $country,
    ) {
    }
}
