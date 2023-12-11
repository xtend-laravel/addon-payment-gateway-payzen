<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Payzen;

use Saloon\Http\Connector;

class PayzenApiConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://api.payzen.eu/api-payment/V4';
    }

    public function __construct(string $username, string $password)
    {
        $this->withBasicAuth($username, $password);
    }

    protected function defaultConfig(): array
    {
        return [
            //'debug' => true,
        ];
    }
}
