<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        #[Max(63)]
        public string $reference,
        #[Email, Max(150)]
        public string $email,
        #[Nullable]
        public ?CustomerBillingData $billing,
    ) {
    }
}
