<?php

namespace XtendLunar\Addons\PaymentGatewayPayzen\Restify;

use XtendLunar\Addons\PaymentGatewayPayzen\Restify\Presenters\PayzenPresenter;
use XtendLunar\Addons\RestifyApi\Restify\Repository;

class PayzenRepository extends Repository
{
    public static string $presenter = PayzenPresenter::class;
}
