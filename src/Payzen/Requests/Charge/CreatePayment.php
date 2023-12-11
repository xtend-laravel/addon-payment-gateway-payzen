<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Payzen\Requests\Charge;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreatePayment extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload
    ){}

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function resolveEndpoint(): string
    {
        return '/Charge/CreatePayment';
    }
}
