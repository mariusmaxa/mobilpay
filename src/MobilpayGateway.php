<?php

namespace Adrianbarbos\Mobilpay;

use Omnipay\Omnipay;

class MobilpayGateway
{
    protected $data;

    use DataTrait;

    public function __construct()
    {
        $this->initData();
    }

    public function purchase($autoRedirect = true, $uo)
    {
        $gateway = Omnipay::create('MobilPay');
        $gateway->setMerchantId(config('mobilpay.merchant_id' . '_' . $uo));
        $gateway->setPublicKey(config('mobilpay.public_key_path' . '_' . $uo));

        $response = $gateway->purchase($this->data)->send();

        if ($autoRedirect) {
            $response->redirect();
        }

        return $response;
    }

    public function response($autoSendResponse = true, $uo)
    {
        $gateway = Omnipay::create('MobilPay');
        $gateway->setPrivateKey(config('mobilpay.private_key_path' . '_' . $uo));

        $response = $gateway->completePurchase($_POST)->send();

        if ($autoSendResponse) {
            $response->sendResponse();
        }

        return $response;
    }
}
