<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Base;

use XtendLunar\Addons\PaymentGatewayPayzen\Concerns\CanAuthorizePayment;
use XtendLunar\Addons\PaymentGatewayPayzen\Concerns\CanCapturePayment;
use XtendLunar\Addons\PaymentGatewayPayzen\Concerns\CanRefundPayment;
use XtendLunar\Addons\PaymentGatewayPayzen\Concerns\WithCreatePayment;
use XtendLunar\Addons\PaymentGatewayPayzen\Concerns\WithPayzenClient;
use XtendLunar\Features\PaymentGateways\Base\AbstractPaymentGateway;
use XtendLunar\Features\PaymentGateways\Contracts\OnlinePaymentGateway;

class PayzenPayment extends AbstractPaymentGateway implements OnlinePaymentGateway
{
    use WithPayzenClient;
    use WithCreatePayment;
    use CanAuthorizePayment;
    use CanCapturePayment;
    use CanRefundPayment;

    public function init(): self
    {
        $this->initPayzen();
        return $this;
    }
}
