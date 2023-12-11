<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Transaction\Data;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;

class TransactionData extends Data
{
    public function __construct(
        #[Uuid]
        public string $uuid,
        #[Nullable, Max(255)]
        public ?string $comment = null,
    ) {
    }
}
