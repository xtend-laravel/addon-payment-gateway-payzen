<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Concerns;

use Illuminate\Support\Facades\App;
use XtendLunar\Addons\PaymentGatewayPayzen\Base\PayzenConnectInterface;
use XtendLunar\Addons\PaymentGatewayPayzen\Payzen\PayzenApiConnector;

trait WithPayzenClient
{
    protected static PayzenApiConnector $payzen;

    protected static mixed $accessToken;

    protected static function initPayzen(): void
    {
        static::$payzen = App::make(PayzenConnectInterface::class);
        // static::$payzen->getAccessToken();
    }

    protected static function withPayzenHeaders(array $headers = [], ?string $idempotencyKey = null): array
    {
        return array_merge($headers, static::idempotencyKeyHeader($idempotencyKey));
    }

    protected static function idempotencyKeyHeader(?string $idempotencyKey): array
    {
        if (!$idempotencyKey) {
            return [];
        }

        return [
            'idempotency_key' => $idempotencyKey,
        ];
    }
}
