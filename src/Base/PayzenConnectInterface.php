<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Base;

interface PayzenConnectInterface
{
    public function createCustomer(string $email): string;

    public function createProduct(string $name): string;

    public function createPrice(string $productId, int $amount): string;

    public function createCheckoutSession(array $data): string;
}
