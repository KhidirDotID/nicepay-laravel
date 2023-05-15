<?php

namespace KhidirDotID\Nicepay;

use KhidirDotID\Nicepay\NicepayConfig;
use KhidirDotID\Nicepay\NicepayRequestor;

class NicepayLib extends NicepayConfig
{
    public $error;
    public $request;

    public $requestData = [];
    public $notification = [];

    public function __construct()
    {
        $this->registerNicepayConfig();
        $this->request = new NicepayRequestor;
    }

    protected function registerNicepayConfig()
    {
        $isProduction = config('nicepay.is_production');
        $this->setMerchantId($isProduction ? config('nicepay.merchant_id') : 'IONPAYTEST');
        $this->setMerchantKey($isProduction ? config('nicepay.merchant_key') : '33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==');
        $this->setCallbackUrl(config('nicepay.callback_url'));
        $this->setNotificationUrl(config('nicepay.notification_url'));
    }

    // Set POST parameter name and its value
    public function set($name, $value)
    {
        $this->requestData[$name] = $value;
    }

    // Retrieve POST parameter value
    public function get($name)
    {
        return isset($this->requestData[$name]) ? $this->requestData[$name] : '';
    }

    // Charge Credit Card
    public function requestCC($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        $this->set('dbProcessUrl', $this->getNotificationUrl());
        // $this->set('callBackUrl', $this->getCallbackUrl());
        $this->set('userIP', $this->getUserIP());
        $this->set('goodsNm', $this->get('description'));
        $this->set('notaxAmt', '0');
        $this->set('reqDomain', 'http://localhost/');

        if ($this->get('fee') == '') {
            $this->set('fee', '0');
        }
        if ($this->get('vat') == '') {
            $this->set('vat', '0');
        }
        if ($this->get('cartData') == '') {
            $this->set('cartData', '{"count": 1, "item": [{"img_url": "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704", "goods_name": "iPhone 11", "goods_detail": "A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.", "goods_amt": ' . $this->get('amt') . '}]}');
        }

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('iMid', '02');
        $this->checkParam('payMethod', '03');
        $this->checkParam('currency', '04');
        $this->checkParam('amt', '05');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('goodsNm', '07');
        $this->checkParam('billingNm', '08');
        $this->checkParam('billingPhone', '09');
        $this->checkParam('billingEmail', '10');
        $this->checkParam('billingAddr', '11');
        $this->checkParam('billingCity', '12');
        $this->checkParam('billingState', '13');
        $this->checkParam('billingPostCd', '14');
        $this->checkParam('billingCountry', '15');
        $this->checkParam('deliveryNm', '16');
        $this->checkParam('deliveryPhone', '17');
        $this->checkParam('deliveryAddr', '18');
        $this->checkParam('deliveryCity', '19');
        $this->checkParam('deliveryState', '20');
        $this->checkParam('deliveryPostCd', '21');
        $this->checkParam('deliveryCountry', '22');
        $this->checkParam('dbProcessUrl', '23');
        $this->checkParam('vat', '24');
        $this->checkParam('fee', '25');
        $this->checkParam('notaxAmt', '26');
        $this->checkParam('description', '27');
        $this->checkParam('merchantToken', '28');
        $this->checkParam('reqDt', '29');
        $this->checkParam('reqTm', '30');
        $this->checkParam('userIP', '34');
        $this->checkParam('cartData', '38');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Request Virtual Account
    public function requestVA($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        $this->set('dbProcessUrl', $this->getNotificationUrl());
        // $this->set('callBackUrl', $this->getCallbackUrl());
        $this->set('userIP', $this->getUserIP());
        $this->set('goodsNm', $this->get('description'));
        $this->set('notaxAmt', '0');
        $this->set('reqDomain', 'http://localhost/');

        if ($this->get('fee') == '') {
            $this->set('fee', '0');
        }
        if ($this->get('vat') == '') {
            $this->set('vat', '0');
        }
        if ($this->get('cartData') == '') {
            $this->set('cartData', '{}');
        }

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('iMid', '02');
        $this->checkParam('payMethod', '03');
        $this->checkParam('currency', '04');
        $this->checkParam('amt', '05');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('goodsNm', '07');
        $this->checkParam('billingNm', '08');
        $this->checkParam('billingPhone', '09');
        $this->checkParam('billingEmail', '10');
        $this->checkParam('billingAddr', '11');
        $this->checkParam('billingCity', '12');
        $this->checkParam('billingState', '13');
        $this->checkParam('billingPostCd', '14');
        $this->checkParam('billingCountry', '15');
        $this->checkParam('deliveryNm', '16');
        $this->checkParam('deliveryPhone', '17');
        $this->checkParam('deliveryAddr', '18');
        $this->checkParam('deliveryCity', '19');
        $this->checkParam('deliveryState', '20');
        $this->checkParam('deliveryPostCd', '21');
        $this->checkParam('deliveryCountry', '22');
        $this->checkParam('dbProcessUrl', '23');
        $this->checkParam('vat', '24');
        $this->checkParam('fee', '25');
        $this->checkParam('notaxAmt', '26');
        $this->checkParam('description', '27');
        $this->checkParam('merchantToken', '28');
        $this->checkParam('reqDt', '29');
        $this->checkParam('reqTm', '30');
        $this->checkParam('userIP', '34');
        $this->checkParam('cartData', '38');
        $this->checkParam('bankCd', '42');
        $this->checkParam('vacctValidDt', '43');
        $this->checkParam('vacctValidTm', '44');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Request CVS
    public function requestCVS($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        $this->set('dbProcessUrl', $this->getNotificationUrl());
        // $this->set('callBackUrl', $this->getCallbackUrl());
        $this->set('userIP', $this->getUserIP());
        $this->set('goodsNm', $this->get('description'));
        $this->set('notaxAmt', '0');
        $this->set('reqDomain', 'http://localhost/');

        if ($this->get('fee') == '') {
            $this->set('fee', '0');
        }
        if ($this->get('vat') == '') {
            $this->set('vat', '0');
        }
        if ($this->get('cartData') == '') {
            $this->set('cartData', '{}');
        }

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('iMid', '02');
        $this->checkParam('payMethod', '03');
        $this->checkParam('currency', '04');
        $this->checkParam('amt', '05');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('goodsNm', '07');
        $this->checkParam('billingNm', '08');
        $this->checkParam('billingPhone', '09');
        $this->checkParam('billingEmail', '10');
        $this->checkParam('billingAddr', '11');
        $this->checkParam('billingCity', '12');
        $this->checkParam('billingState', '13');
        $this->checkParam('billingPostCd', '14');
        $this->checkParam('billingCountry', '15');
        $this->checkParam('deliveryNm', '16');
        $this->checkParam('deliveryPhone', '17');
        $this->checkParam('deliveryAddr', '18');
        $this->checkParam('deliveryCity', '19');
        $this->checkParam('deliveryState', '20');
        $this->checkParam('deliveryPostCd', '21');
        $this->checkParam('deliveryCountry', '22');
        $this->checkParam('dbProcessUrl', '23');
        $this->checkParam('vat', '24');
        $this->checkParam('fee', '25');
        $this->checkParam('notaxAmt', '26');
        $this->checkParam('description', '27');
        $this->checkParam('merchantToken', '28');
        $this->checkParam('reqDt', '29');
        $this->checkParam('reqTm', '30');
        $this->checkParam('userIP', '34');
        $this->checkParam('cartData', '38');
        $this->checkParam('mitraCd', '36');
        $this->checkParam('payValidDt', '43');
        $this->checkParam('payValidTm', '44');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Request Clickpay Jenius
    public function requestClickPay($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        $this->set('dbProcessUrl', $this->getNotificationUrl());
        // $this->set('callBackUrl', $this->getCallbackUrl());
        $this->set('userIP', $this->getUserIP());
        $this->set('goodsNm', $this->get('description'));
        $this->set('notaxAmt', '0');
        $this->set('reqDomain', 'http://localhost/');

        if ($this->get('fee') == '') {
            $this->set('fee', '0');
        }
        if ($this->get('vat') == '') {
            $this->set('vat', '0');
        }
        if ($this->get('cartData') == '') {
            $this->set('cartData', '{}');
        }

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('iMid', '02');
        $this->checkParam('payMethod', '03');
        $this->checkParam('currency', '04');
        $this->checkParam('amt', '05');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('goodsNm', '07');
        $this->checkParam('billingNm', '08');
        $this->checkParam('billingPhone', '09');
        $this->checkParam('billingEmail', '10');
        $this->checkParam('billingAddr', '11');
        $this->checkParam('billingCity', '12');
        $this->checkParam('billingState', '13');
        $this->checkParam('billingPostCd', '14');
        $this->checkParam('billingCountry', '15');
        $this->checkParam('deliveryNm', '16');
        $this->checkParam('deliveryPhone', '17');
        $this->checkParam('deliveryAddr', '18');
        $this->checkParam('deliveryCity', '19');
        $this->checkParam('deliveryState', '20');
        $this->checkParam('deliveryPostCd', '21');
        $this->checkParam('deliveryCountry', '22');
        $this->checkParam('dbProcessUrl', '23');
        $this->checkParam('vat', '24');
        $this->checkParam('fee', '25');
        $this->checkParam('notaxAmt', '26');
        $this->checkParam('description', '27');
        $this->checkParam('merchantToken', '28');
        $this->checkParam('reqDt', '29');
        $this->checkParam('reqTm', '30');
        $this->checkParam('userIP', '34');
        $this->checkParam('cartData', '35');
        $this->checkParam('mitraCd', '36');
        // $this->checkParam('cashtag', '37');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Request Ewallet
    public function requestEWallet($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        $this->set('dbProcessUrl', $this->getNotificationUrl());
        // $this->set('callBackUrl', $this->getCallbackUrl());
        $this->set('userIP', $this->getUserIP());
        $this->set('goodsNm', $this->get('description'));
        $this->set('notaxAmt', '0');
        $this->set('reqDomain', 'http://localhost/');

        if ($this->get('fee') == '') {
            $this->set('fee', '0');
        }
        if ($this->get('vat') == '') {
            $this->set('vat', '0');
        }
        if ($this->get('cartData') == '') {
            if ($this->get('mitraCd') == 'OVOE') {
                $this->set('cartData', '{"count": 1, "item": [{"img_url": "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704", "goods_name": "iPhone 11", "goods_detail": "A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.", "goods_amt": ' . $this->get('amt') . '}]}');
            } elseif ($this->get('mitraCd') == 'DANA') {
                $this->set('cartData', '{"count": 1, "item": [{"img_url": "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704", "goods_name": "iPhone 11", "goods_quantity": 1, "goods_detail": "A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.", "goods_amt": ' . $this->get('amt') . '}]}');
            } elseif ($this->get('mitraCd') == 'LINK') {
                $this->set('cartData', '{"count": 1, "item": [{"img_url": "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704", "goods_name": "iPhone 11", "goods_quantity": 1, "goods_detail": "A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.", "goods_amt": ' . $this->get('amt') . '}]}');
            } elseif ($this->get('mitraCd') == 'ESHP') {
                $this->set('cartData', '{"count": 1, "item": [{"img_url": "https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704", "goods_name": "iPhone 11", "goods_quantity": 1, "goods_detail": "A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.", "goods_amt": ' . $this->get('amt') . '}]}');
            }
        }

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('iMid', '02');
        $this->checkParam('payMethod', '03');
        $this->checkParam('currency', '04');
        $this->checkParam('amt', '05');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('goodsNm', '07');
        $this->checkParam('billingNm', '08');
        $this->checkParam('billingPhone', '09');
        $this->checkParam('billingEmail', '10');
        $this->checkParam('billingAddr', '11');
        $this->checkParam('billingCity', '12');
        $this->checkParam('billingState', '13');
        $this->checkParam('billingPostCd', '14');
        $this->checkParam('billingCountry', '15');
        $this->checkParam('cartData', '38');
        $this->checkParam('mitraCd', '36');
        $this->checkParam('userIP', '34');
        $this->checkParam('dbProcessUrl', '23');
        $this->checkParam('merchantToken', '28');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Request Payloan
    public function requestPayloan($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        $this->set('dbProcessUrl', $this->getNotificationUrl());
        // $this->set('callBackUrl', $this->getCallbackUrl());
        $this->set('userIP', $this->getUserIP());
        $this->set('notaxAmt', '0');
        $this->set('reqDomain', 'http://localhost/');

        if ($this->get('fee') == '') {
            $this->set('fee', '0');
        }
        if ($this->get('vat') == '') {
            $this->set('vat', '0');
        }

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('iMid', '02');
        $this->checkParam('payMethod', '03');
        $this->checkParam('currency', '04');
        $this->checkParam('amt', '05');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('goodsNm', '07');
        $this->checkParam('billingNm', '08');
        $this->checkParam('billingPhone', '09');
        $this->checkParam('billingEmail', '10');
        $this->checkParam('billingAddr', '11');
        $this->checkParam('billingCity', '12');
        $this->checkParam('billingState', '13');
        $this->checkParam('billingPostCd', '14');
        $this->checkParam('billingCountry', '15');
        $this->checkParam('deliveryNm', '16');
        $this->checkParam('deliveryPhone', '17');
        $this->checkParam('deliveryAddr', '18');
        $this->checkParam('deliveryCity', '19');
        $this->checkParam('deliveryState', '20');
        $this->checkParam('deliveryPostCd', '21');
        $this->checkParam('deliveryCountry', '22');
        $this->checkParam('dbProcessUrl', '23');
        $this->checkParam('notaxAmt', '26');
        $this->checkParam('description', '27');
        $this->checkParam('merchantToken', '28');
        $this->checkParam('reqDt', '29');
        $this->checkParam('reqTm', '30');
        $this->checkParam('userIP', '34');
        $this->checkParam('cartData', '38');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Request QRIS
    public function requestQris($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            $this->set($key, $value);
        }
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        $this->set('dbProcessUrl', $this->getNotificationUrl());
        // $this->set('callBackUrl', $this->getCallbackUrl());
        $this->set('userIP', $this->getUserIP());
        $this->set('goodsNm', $this->get('description'));
        $this->set('notaxAmt', '0');
        $this->set('reqDomain', 'http://localhost/');

        if ($this->get('fee') == '') {
            $this->set('fee', '0');
        }
        if ($this->get('vat') == '') {
            $this->set('vat', '0');
        }
        if ($this->get('cartData') == '') {
            $this->set('cartData', '{}');
        }

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('iMid', '02');
        $this->checkParam('payMethod', '03');
        $this->checkParam('currency', '04');
        $this->checkParam('amt', '05');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('goodsNm', '07');
        $this->checkParam('billingNm', '08');
        $this->checkParam('billingPhone', '09');
        $this->checkParam('billingEmail', '10');
        $this->checkParam('billingAddr', '11');
        $this->checkParam('billingCity', '12');
        $this->checkParam('billingState', '13');
        $this->checkParam('billingPostCd', '14');
        $this->checkParam('billingCountry', '15');
        $this->checkParam('deliveryNm', '16');
        $this->checkParam('deliveryPhone', '17');
        $this->checkParam('deliveryAddr', '18');
        $this->checkParam('deliveryCity', '19');
        $this->checkParam('deliveryState', '20');
        $this->checkParam('deliveryPostCd', '21');
        $this->checkParam('deliveryCountry', '22');
        $this->checkParam('dbProcessUrl', '23');
        $this->checkParam('vat', '24');
        $this->checkParam('fee', '25');
        $this->checkParam('notaxAmt', '26');
        $this->checkParam('description', '27');
        $this->checkParam('merchantToken', '28');
        $this->checkParam('reqDt', '29');
        $this->checkParam('reqTm', '30');
        $this->checkParam('userIP', '34');
        $this->checkParam('cartData', '35');
        $this->checkParam('mitraCd', '36');
        $this->checkParam('shopId', '37');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Check Payment Status
    public function checkPaymentStatus($tXid, $referenceNo, $amt)
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('referenceNo', $referenceNo);
        $this->set('tXid', $tXid);
        $this->set('amt', $amt);
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantToken());
        unset($this->requestData['merchantKey']);

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('tXid', '30');
        $this->checkParam('iMid', '02');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('amt', '05');
        $this->checkParam('merchantToken', '28');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_ORDER_STATUS_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Cancel Transaction
    public function cancelTrans($tXid, $amt)
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('tXid', $tXid);
        $this->set('amt', $amt);
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantTokenCancel());
        unset($this->requestData['merchantKey']);

        // Check Parameter
        $this->checkParam('timeStamp', '01');
        $this->checkParam('tXid', '47');
        $this->checkParam('iMid', '02');
        $this->checkParam('referenceNo', '06');
        $this->checkParam('amt', '05');
        $this->checkParam('merchantToken', '28');

        if ($this->error) return $this->error;

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_CANCEL_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Request Payout
    public function requestPayout($amt, $accountNo)
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('amt', $amt);
        $this->set('accountNo', $accountNo);
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantTokenPayout());
        unset($this->requestData['merchantKey']);

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REQ_PAYOUT_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Approve Payout
    public function approvePayout($tXid)
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('tXid', $tXid);
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantTokenApprovePayout());
        unset($this->requestData['merchantKey']);

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_APPROVE_PAYOUT_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Reject Payout
    public function rejectPayout($tXid)
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('tXid', $tXid);
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantTokenRejectPayout());
        unset($this->requestData['merchantKey']);

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_REJECT_PAYOUT_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Inquiry Payout
    public function inquiryPayout($tXid, $accountNo)
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('tXid', $tXid);
        $this->set('accountNo', $accountNo);
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantTokenInquiryPayout());
        unset($this->requestData['merchantKey']);

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_INQUIRY_PAYOUT_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Check Balance
    public function balanceInquiry()
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantTokenBalance());
        unset($this->requestData['merchantKey']);

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_BALANCE_PAYOUT_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    // Cancel Payout
    public function cancelPayout($tXid)
    {
        // Populate data
        $this->set('timeStamp', date('YmdHis'));
        $this->set('iMid', $this->getMerchantId());
        $this->set('tXid', $tXid);
        $this->set('merchantKey', $this->getMerchantKey());
        $this->set('merchantToken', $this->getMerchantTokenCancelPayout());
        unset($this->requestData['merchantKey']);

        // Send Request
        $resultData = $this->request->apiRequest(NicepayConfig::NICEPAY_CANCEL_PAYOUT_URL, $this->requestData);
        unset($this->requestData);

        return $resultData;
    }

    public function checkParam($requestData, $errorNo)
    {
        if ($this->get($requestData) == null) {
            $this->error = $this->getError($errorNo);
        }
    }

    public function getMerchantToken()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('referenceNo') . $this->get('amt') . $this->get('merchantKey'));
    }

    public function getMerchantTokenCancel()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('tXid') . $this->get('amt') . $this->get('merchantKey'));
    }

    public function getMerchantTokenPayout()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('amt') . $this->get('accountNo') . $this->get('merchantKey'));
    }

    public function getMerchantTokenApprovePayout()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('tXid') . $this->get('merchantKey'));
    }

    public function getMerchantTokenRejectPayout()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('tXid') . $this->get('merchantKey'));
    }

    public function getMerchantTokenInquiryPayout()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('tXid') . $this->get('accountNo') . $this->get('merchantKey'));
    }

    public function getMerchantTokenBalance()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('merchantKey'));
    }

    public function getMerchantTokenCancelPayout()
    {
        return hash('sha256', $this->get('timeStamp') . $this->get('iMid') . $this->get('tXid') . $this->get('merchantKey'));
    }

    public function getError($id)
    {
        $error = [
            // That always Unknown Error :)
            '00' => [
                'resultCd'  => '00000',
                'resultMsg' => 'Unknown error. Contact it.support@ionpay.net.'
            ],
            // General Mandatory parameters
            '01' => [
                'resultCd'  => '10001',
                'resultMsg' => '(timeStamp) is not set. Please set (timeStamp).'
            ],
            '02' => [
                'resultCd'  => '10002',
                'resultMsg' => '(iMid) is not set. Please set (iMid).'
            ],
            '03' => [
                'resultCd'  => '10003',
                'resultMsg' => '(payMethod) is not set. Please set (payMethod).'
            ],
            '04' => [
                'resultCd'  => '10004',
                'resultMsg' => '(currency) is not set. Please set (currency).'
            ],
            '05' => [
                'resultCd'  => '10005',
                'resultMsg' => '(amt) is not set. Please set (amt).'
            ],
            '06' => [
                'resultCd'  => '10006',
                'resultMsg' => '(referenceNo) is not set. Please set (referenceNo).'
            ],
            '07' => [
                'resultCd'  => '10007',
                'resultMsg' => '(goodsNm) is not set. Please set (goodsNm).'
            ],
            '08' => [
                'resultCd'  => '10008',
                'resultMsg' => '(billingNm) is not set. Please set (billingNm).'
            ],
            '09' => [
                'resultCd'  => '10009',
                'resultMsg' => '(billingPhone) is not set. Please set (billingPhone).'
            ],
            '10' => [
                'resultCd'  => '10010',
                'resultMsg' => '(billingEmail) is not set. Please set (billingEmail).'
            ],
            '11' => [
                'resultCd'  => '10011',
                'resultMsg' => '(billingAddr) is not set. Please set (billingAddr).'
            ],
            '12' => [
                'resultCd'  => '10012',
                'resultMsg' => '(billingCity) is not set. Please set (billingCity).'
            ],
            '13' => [
                'resultCd'  => '10013',
                'resultMsg' => '(billingState) is not set. Please set (billingState).'
            ],
            '14' => [
                'resultCd'  => '10014',
                'resultMsg' => '(billingPostCd) is not set. Please set (billingPostCd).'
            ],
            '15' => [
                'resultCd'  => '10015',
                'resultMsg' => '(billingCountry) is not set. Please set (billingCountry).'
            ],
            '16' => [
                'resultCd'  => '10016',
                'resultMsg' => '(deliveryNm) is not set. Please set (deliveryNm).'
            ],
            '17' => [
                'resultCd'  => '10017',
                'resultMsg' => '(deliveryPhone) is not set. Please set (deliveryPhone).'
            ],
            '18' => [
                'resultCd'  => '10018',
                'resultMsg' => '(deliveryAddr) is not set. Please set (deliveryAddr).'
            ],
            '19' => [
                'resultCd'  => '10019',
                'resultMsg' => '(deliveryCity) is not set. Please set (deliveryCity).'
            ],
            '20' => [
                'resultCd'  => '10020',
                'resultMsg' => '(deliveryState) is not set. Please set (deliveryState).'
            ],
            '21' => [
                'resultCd'  => '10021',
                'resultMsg' => '(deliveryPostCd) is not set. Please set (deliveryPostCd).'
            ],
            '22' => [
                'resultCd'  => '10022',
                'resultMsg' => '(deliveryCountry) is not set. Please set (deliveryCountry).'
            ],
            '23' => [
                'resultCd'  => '10023',
                'resultMsg' => '(dbProcessUrl) is not set. Please set (dbProcessUrl).'
            ],
            '24' => [
                'resultCd'  => '10024',
                'resultMsg' => '(vat) is not set. Please set (vat).'
            ],
            '25' => [
                'resultCd'  => '10025',
                'resultMsg' => '(fee) is not set. Please set (fee).'
            ],
            '26' => [
                'resultCd'  => '10026',
                'resultMsg' => '(notaxAmt) is not set. Please set (notaxAmt).'
            ],
            '27' => [
                'resultCd'  => '10027',
                'resultMsg' => '(description) is not set. Please set (description).'
            ],
            '28' => [
                'resultCd'  => '10028',
                'resultMsg' => '(merchantToken) is not set. Please set (merchantToken).'
            ],
            '29' => [
                'resultCd'  => '10029',
                'resultMsg' => '(reqDt) is not set. Please set (reqDt).'
            ],
            '30' => [
                'resultCd'  => '10030',
                'resultMsg' => '(reqTm) is not set. Please set (reqTm).'
            ],
            '34' => [
                'resultCd'  => '10034',
                'resultMsg' => '(userIP) is not set. Please set (userIP).'
            ],
            '35' => [
                'resultCd'  => '10035',
                'resultMsg' => '(cartData) is not set. Please set (cartData).'
            ],
            '36' => [
                'resultCd'  => '10036',
                'resultMsg' => '(mitraCd) is not set. Please set (mitraCd).'
            ],
            '37' => [
                'resultCd'  => '10037',
                'resultMsg' => '(shopId) is not set. Please set (shopId).'
            ],
            '38' => [
                'resultCd'  => '10038',
                'resultMsg' => '(cartData) is not set. Please set (cartData).'
            ],
            '42' => [
                'resultCd'  => '10042',
                'resultMsg' => '(bankCd) is not set. Please set (bankCd).'
            ],
            '43' => [
                'resultCd'  => '10043',
                'resultMsg' => '(payValidDt) is not set. Please set (payValidDt).'
            ],
            '44' => [
                'resultCd'  => '10044',
                'resultMsg' => '(payValidTm) is not set. Please set (payValidTm).'
            ],
            '45' => [
                'resultCd'  => '10045',
                'resultMsg' => '(vacctValidDt) is not set. Please set (vacctValidDt).'
            ],
            '46' => [
                'resultCd'  => '10046',
                'resultMsg' => '(vacctValidTm) is not set. Please set (vacctValidTm).'
            ],
            // Mandatory parameters to Check Order Status
            '47' => [
                'resultCd'  => '10047',
                'resultMsg' => '(tXid) is not set. Please set (tXid).'
            ]
        ];
        return (object)$error[$id];
    }

    public function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

    public function oneLiner($string)
    {
        // Return string in one line, remove new lines and white spaces
        return preg_replace(['/\n/', '/\n\r/', '/\r\n/', '/\r/', '/\s+/', '/\s\s*/'], ' ', $string);
    }

    public function extractNotification($name)
    {
        if (is_array($name)) {
            foreach ($name as $value) {
                if (isset($_REQUEST[$value])) {
                    $this->notification[$value] = $_REQUEST[$value];
                } else {
                    $this->notification[$value] = null;
                }
            }
        } elseif (isset($_REQUEST[$name])) {
            $this->notification[$name] = $_REQUEST[$name];
        } else {
            $this->notification[$name] = null;
        }
    }

    public function getNotification($name)
    {
        return $this->notification[$name];
    }
}
