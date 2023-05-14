<?php

namespace KhidirDotID\Nicepay;

use KhidirDotID\Nicepay\NicepayConfig;
use KhidirDotID\Nicepay\NicepayRequestor;

class NicepayLib extends NicepayConfig
{
    public $requestData = [];
    public $notification = [];

    public function __construct()
    {
        self::registerNicepayConfig();
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
    public static function requestCC($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            self::set($key, $value);
        }
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        self::set('dbProcessUrl', self::getNotificationUrl());
        self::set('callBackUrl', self::getCallbackUrl());
        self::set('userIP', self::getUserIP());
        self::set('goodsNm', self::get('description'));
        self::set('notaxAmt', '0');
        self::set('reqDomain', 'http://localhost/');

        if (self::get('fee') == '') {
            self::set('fee', '0');
        }
        if (self::get('vat') == '') {
            self::set('vat', '0');
        }
        if (self::get('cartData') == '') {
            self::set('cartData', "{\"count\": \"1\",\"item\": [{\"img_url\": \"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704\",\"goods_name\": \" iPhone 11 \",\"goods_detail\": \"A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.\",\"goods_amt\":" . "\"" . self::get('amt') . "\"}]}");
        }

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('iMid', '02');
        self::checkParam('payMethod', '03');
        self::checkParam('currency', '04');
        self::checkParam('amt', '05');
        self::checkParam('referenceNo', '06');
        self::checkParam('goodsNm', '07');
        self::checkParam('billingNm', '08');
        self::checkParam('billingPhone', '09');
        self::checkParam('billingEmail', '10');
        self::checkParam('billingAddr', '11');
        self::checkParam('billingCity', '12');
        self::checkParam('billingState', '13');
        self::checkParam('billingPostCd', '14');
        self::checkParam('billingCountry', '15');
        self::checkParam('deliveryNm', '16');
        self::checkParam('deliveryPhone', '17');
        self::checkParam('deliveryAddr', '18');
        self::checkParam('deliveryCity', '19');
        self::checkParam('deliveryState', '20');
        self::checkParam('deliveryPostCd', '21');
        self::checkParam('deliveryCountry', '22');
        self::checkParam('dbProcessUrl', '23');
        self::checkParam('vat', '24');
        self::checkParam('fee', '25');
        self::checkParam('notaxAmt', '26');
        self::checkParam('description', '27');
        self::checkParam('merchantToken', '28');
        self::checkParam('reqDt', '29');
        self::checkParam('reqTm', '30');
        self::checkParam('userIP', '34');
        self::checkParam('cartData', '38');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Request Virtual Account
    public static function requestVA($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            self::set($key, $value);
        }
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        self::set('dbProcessUrl', self::getNotificationUrl());
        self::set('callBackUrl', self::getCallbackUrl());
        self::set('userIP', self::getUserIP());
        self::set('goodsNm', self::get('description'));
        self::set('notaxAmt', '0');
        self::set('reqDomain', 'http://localhost/');

        if (self::get('fee') == '') {
            self::set('fee', '0');
        }
        if (self::get('vat') == '') {
            self::set('vat', '0');
        }
        if (self::get('cartData') == '') {
            self::set('cartData', '{}');
        }

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('iMid', '02');
        self::checkParam('payMethod', '03');
        self::checkParam('currency', '04');
        self::checkParam('amt', '05');
        self::checkParam('referenceNo', '06');
        self::checkParam('goodsNm', '07');
        self::checkParam('billingNm', '08');
        self::checkParam('billingPhone', '09');
        self::checkParam('billingEmail', '10');
        self::checkParam('billingAddr', '11');
        self::checkParam('billingCity', '12');
        self::checkParam('billingState', '13');
        self::checkParam('billingPostCd', '14');
        self::checkParam('billingCountry', '15');
        self::checkParam('deliveryNm', '16');
        self::checkParam('deliveryPhone', '17');
        self::checkParam('deliveryAddr', '18');
        self::checkParam('deliveryCity', '19');
        self::checkParam('deliveryState', '20');
        self::checkParam('deliveryPostCd', '21');
        self::checkParam('deliveryCountry', '22');
        self::checkParam('dbProcessUrl', '23');
        self::checkParam('vat', '24');
        self::checkParam('fee', '25');
        self::checkParam('notaxAmt', '26');
        self::checkParam('description', '27');
        self::checkParam('merchantToken', '28');
        self::checkParam('reqDt', '29');
        self::checkParam('reqTm', '30');
        self::checkParam('userIP', '34');
        self::checkParam('cartData', '38');
        self::checkParam('bankCd', '42');
        self::checkParam('vacctValidDt', '43');
        self::checkParam('vacctValidTm', '44');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Request CVS
    public static function requestCVS($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            self::set($key, $value);
        }
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        self::set('dbProcessUrl', self::getNotificationUrl());
        self::set('callBackUrl', self::getCallbackUrl());
        self::set('userIP', self::getUserIP());
        self::set('goodsNm', self::get('description'));
        self::set('notaxAmt', '0');
        self::set('reqDomain', 'http://localhost/');

        if (self::get('fee') == "") {
            self::set('fee', '0');
        }
        if (self::get('vat') == "") {
            self::set('vat', '0');
        }
        if (self::get('cartData') == "") {
            self::set('cartData', '{}');
        }

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('iMid', '02');
        self::checkParam('payMethod', '03');
        self::checkParam('currency', '04');
        self::checkParam('amt', '05');
        self::checkParam('referenceNo', '06');
        self::checkParam('goodsNm', '07');
        self::checkParam('billingNm', '08');
        self::checkParam('billingPhone', '09');
        self::checkParam('billingEmail', '10');
        self::checkParam('billingAddr', '11');
        self::checkParam('billingCity', '12');
        self::checkParam('billingState', '13');
        self::checkParam('billingPostCd', '14');
        self::checkParam('billingCountry', '15');
        self::checkParam('deliveryNm', '16');
        self::checkParam('deliveryPhone', '17');
        self::checkParam('deliveryAddr', '18');
        self::checkParam('deliveryCity', '19');
        self::checkParam('deliveryState', '20');
        self::checkParam('deliveryPostCd', '21');
        self::checkParam('deliveryCountry', '22');
        self::checkParam('dbProcessUrl', '23');
        self::checkParam('vat', '24');
        self::checkParam('fee', '25');
        self::checkParam('notaxAmt', '26');
        self::checkParam('description', '27');
        self::checkParam('merchantToken', '28');
        self::checkParam('reqDt', '29');
        self::checkParam('reqTm', '30');
        self::checkParam('userIP', '34');
        self::checkParam('cartData', '38');
        self::checkParam('mitraCd', '36');
        self::checkParam('payValidDt', '43');
        self::checkParam('payValidTm', '44');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Request Ewallet
    public static function requestEWallet($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            self::set($key, $value);
        }
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        self::set('dbProcessUrl', self::getNotificationUrl());
        self::set('callBackUrl', self::getCallbackUrl());
        self::set('userIP', self::getUserIP());
        self::set('goodsNm', self::get('description'));
        self::set('notaxAmt', '0');
        self::set('reqDomain', 'http://localhost/');

        if (self::get('fee') == "") {
            self::set('fee', '0');
        }
        if (self::get('vat') == "") {
            self::set('vat', '0');
        }
        if (self::get('cartData') == "") {
            if (self::get('mitraCd') == "OVOE") {
                self::set('cartData', "{\"count\": \"1\",\"item\": [{\"img_url\": \"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704\",\"goods_name\": \" iPhone 11 \",\"goods_detail\": \"A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.\",\"goods_amt\":" . "\"" . self::get('amt') . "\"}]}");
            } elseif (self::get('mitraCd') == "DANA") {
                self::set('cartData', "{\"count\": \"1\",\"item\": [{\"img_url\": \"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704\",\"goods_name\": \" iPhone 11 \",\"goods_quantity\": \"1\",\"goods_detail\": \"A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.\",\"goods_amt\":" . "\"" . self::get('amt') . "\"}]}");
            } elseif (self::get('mitraCd') == "LINK") {
                self::set('cartData', "{\"count\": \"1\",\"item\": [{\"img_url\": \"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704\",\"goods_name\": \" iPhone 11 \",\"goods_quantity\": \"1\",\"goods_detail\": \"A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.\",\"goods_amt\":" . "\"" . self::get('amt') . "\"}]}");
            } elseif (self::get('mitraCd') == "ESHP") {
                self::set('cartData', "{\"count\": \"1\",\"item\": [{\"img_url\": \"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone11-select-2019-family?wid=882&amp;hei=1058&amp;fmt=jpeg&amp;qlt=80&amp;op_usm=0.5,0.5&amp;.v=1567022175704\",\"goods_name\": \" iPhone 11 \",\"goods_quantity\": \"1\",\"goods_detail\": \"A new dual‑camera system captures more of what you see and love. The fastest chip ever in a smartphone and all‑day battery life let you do more and charge less. And the highest‑quality video in a smartphone, so your memories look better than ever.\",\"goods_amt\":" . "\"" . self::get('amt') . "\"}]}");
            }
        }

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('iMid', '02');
        self::checkParam('payMethod', '03');
        self::checkParam('currency', '04');
        self::checkParam('amt', '05');
        self::checkParam('referenceNo', '06');
        self::checkParam('goodsNm', '07');
        self::checkParam('billingNm', '08');
        self::checkParam('billingPhone', '09');
        self::checkParam('billingEmail', '10');
        self::checkParam('billingAddr', '11');
        self::checkParam('billingCity', '12');
        self::checkParam('billingState', '13');
        self::checkParam('billingPostCd', '14');
        self::checkParam('billingCountry', '15');
        self::checkParam('cartData', '38');
        self::checkParam('mitraCd', '36');
        self::checkParam('userIP', '34');
        self::checkParam('dbProcessUrl', '23');
        self::checkParam('merchantToken', '28');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Request QRIS
    public static function requestQris($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            self::set($key, $value);
        }
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        self::set('dbProcessUrl', self::getNotificationUrl());
        self::set('callBackUrl', self::getCallbackUrl());
        self::set('userIP', self::getUserIP());
        self::set('goodsNm', self::get('description'));
        self::set('notaxAmt', '0');
        self::set('reqDomain', 'http://localhost/');

        if (self::get('fee') == "") {
            self::set('fee', '0');
        }
        if (self::get('vat') == "") {
            self::set('vat', '0');
        }
        if (self::get('cartData') == "") {
            self::set('cartData', '{}');
        }

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('iMid', '02');
        self::checkParam('payMethod', '03');
        self::checkParam('currency', '04');
        self::checkParam('amt', '05');
        self::checkParam('referenceNo', '06');
        self::checkParam('goodsNm', '07');
        self::checkParam('billingNm', '08');
        self::checkParam('billingPhone', '09');
        self::checkParam('billingEmail', '10');
        self::checkParam('billingAddr', '11');
        self::checkParam('billingCity', '12');
        self::checkParam('billingState', '13');
        self::checkParam('billingPostCd', '14');
        self::checkParam('billingCountry', '15');
        self::checkParam('deliveryNm', '16');
        self::checkParam('deliveryPhone', '17');
        self::checkParam('deliveryAddr', '18');
        self::checkParam('deliveryCity', '19');
        self::checkParam('deliveryState', '20');
        self::checkParam('deliveryPostCd', '21');
        self::checkParam('deliveryCountry', '22');
        self::checkParam('dbProcessUrl', '23');
        self::checkParam('vat', '24');
        self::checkParam('fee', '25');
        self::checkParam('notaxAmt', '26');
        self::checkParam('description', '27');
        self::checkParam('merchantToken', '28');
        self::checkParam('reqDt', '29');
        self::checkParam('reqTm', '30');
        self::checkParam('userIP', '34');
        self::checkParam('cartData', '35');
        self::checkParam('mitraCd', '36');
        self::checkParam('shopId', '37');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Request Clickpay Jenius
    public static function requestClickPay($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            self::set($key, $value);
        }
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        self::set('dbProcessUrl', self::getNotificationUrl());
        self::set('callBackUrl', self::getCallbackUrl());
        self::set('userIP', self::getUserIP());
        self::set('goodsNm', self::get('description'));
        self::set('notaxAmt', '0');
        self::set('reqDomain', 'http://localhost/');

        if (self::get('fee') == "") {
            self::set('fee', '0');
        }
        if (self::get('vat') == "") {
            self::set('vat', '0');
        }
        if (self::get('cartData') == "") {
            self::set('cartData', '{}');
        }

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('iMid', '02');
        self::checkParam('payMethod', '03');
        self::checkParam('currency', '04');
        self::checkParam('amt', '05');
        self::checkParam('referenceNo', '06');
        self::checkParam('goodsNm', '07');
        self::checkParam('billingNm', '08');
        self::checkParam('billingPhone', '09');
        self::checkParam('billingEmail', '10');
        self::checkParam('billingAddr', '11');
        self::checkParam('billingCity', '12');
        self::checkParam('billingState', '13');
        self::checkParam('billingPostCd', '14');
        self::checkParam('billingCountry', '15');
        self::checkParam('deliveryNm', '16');
        self::checkParam('deliveryPhone', '17');
        self::checkParam('deliveryAddr', '18');
        self::checkParam('deliveryCity', '19');
        self::checkParam('deliveryState', '20');
        self::checkParam('deliveryPostCd', '21');
        self::checkParam('deliveryCountry', '22');
        self::checkParam('dbProcessUrl', '23');
        self::checkParam('vat', '24');
        self::checkParam('fee', '25');
        self::checkParam('notaxAmt', '26');
        self::checkParam('description', '27');
        self::checkParam('merchantToken', '28');
        self::checkParam('reqDt', '29');
        self::checkParam('reqTm', '30');
        self::checkParam('userIP', '34');
        self::checkParam('cartData', '35');
        self::checkParam('mitraCd', '36');
        // self::checkParam('cashtag', '37');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Request Payloan
    public static function requestPayloan($requestData)
    {
        // Populate data
        foreach ($requestData as $key => $value) {
            self::set($key, $value);
        }
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        self::set('dbProcessUrl', self::getNotificationUrl());
        self::set('callBackUrl', self::getCallbackUrl());
        self::set('userIP', self::getUserIP());
        self::set('notaxAmt', '0');
        self::set('reqDomain', 'http://localhost/');

        if (self::get('fee') == "") {
            self::set('fee', '0');
        }
        if (self::get('vat') == "") {
            self::set('vat', '0');
        }

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('iMid', '02');
        self::checkParam('payMethod', '03');
        self::checkParam('currency', '04');
        self::checkParam('amt', '05');
        self::checkParam('referenceNo', '06');
        self::checkParam('goodsNm', '07');
        self::checkParam('billingNm', '08');
        self::checkParam('billingPhone', '09');
        self::checkParam('billingEmail', '10');
        self::checkParam('billingAddr', '11');
        self::checkParam('billingCity', '12');
        self::checkParam('billingState', '13');
        self::checkParam('billingPostCd', '14');
        self::checkParam('billingCountry', '15');
        self::checkParam('deliveryNm', '16');
        self::checkParam('deliveryPhone', '17');
        self::checkParam('deliveryAddr', '18');
        self::checkParam('deliveryCity', '19');
        self::checkParam('deliveryState', '20');
        self::checkParam('deliveryPostCd', '21');
        self::checkParam('deliveryCountry', '22');
        self::checkParam('dbProcessUrl', '23');
        self::checkParam('notaxAmt', '26');
        self::checkParam('description', '27');
        self::checkParam('merchantToken', '28');
        self::checkParam('reqDt', '29');
        self::checkParam('reqTm', '30');
        self::checkParam('userIP', '34');
        self::checkParam('cartData', '38');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Check Payment Status
    public static function checkPaymentStatus($tXid, $referenceNo, $amt)
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('referenceNo', $referenceNo);
        self::set('tXid', $tXid);
        self::set('amt', $amt);
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantToken());
        unset(self::$requestData['merchantKey']);

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('tXid', '30');
        self::checkParam('iMid', '02');
        self::checkParam('referenceNo', '06');
        self::checkParam('amt', '05');
        self::checkParam('merchantToken', '28');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_ORDER_STATUS_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Cancel Transaction
    public static function cancelTrans($tXid, $amt)
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('tXid', $tXid);
        self::set('amt', $amt);
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantTokenCancel());
        unset(self::$requestData['merchantKey']);

        // Check Parameter
        self::checkParam('timeStamp', '01');
        self::checkParam('tXid', '47');
        self::checkParam('iMid', '02');
        self::checkParam('referenceNo', '06');
        self::checkParam('amt', '05');
        self::checkParam('merchantToken', '28');

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_CANCEL_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Request Payout
    public static function requestPayout($amt, $accountNo)
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('amt', $amt);
        self::set('accountNo', $accountNo);
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantTokenPayout());
        unset(self::$requestData['merchantKey']);

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REQ_PAYOUT_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Approve Payout
    public static function approvePayout($tXid)
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('tXid', $tXid);
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantTokenApprovePayout());
        unset(self::$requestData['merchantKey']);

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_APPROVE_PAYOUT_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Reject Payout
    public static function rejectPayout($tXid)
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('tXid', $tXid);
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantTokenRejectPayout());
        unset(self::$requestData['merchantKey']);

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_REJECT_PAYOUT_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Inquiry Payout
    public static function inquiryPayout($tXid, $accountNo)
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('tXid', $tXid);
        self::set('accountNo', $accountNo);
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantTokenInquiryPayout());
        unset(self::$requestData['merchantKey']);

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_INQUIRY_PAYOUT_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Check Balance
    public static function balanceInquiry()
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantTokenBalance());
        unset(self::$requestData['merchantKey']);

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_BALANCE_PAYOUT_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    // Cancel Payout
    public static function cancelPayout($tXid)
    {
        // Populate data
        self::set('timeStamp', date('YmdHis'));
        self::set('iMid', self::getMerchantId());
        self::set('tXid', $tXid);
        self::set('merchantKey', self::getMerchantKey());
        self::set('merchantToken', self::getMerchantTokenCancelPayout());
        unset(self::$requestData['merchantKey']);

        // Send Request
        $resultData = NicepayRequestor::apiRequest(NicepayConfig::NICEPAY_CANCEL_PAYOUT_URL, self::$requestData);
        unset(self::$requestData);

        return $resultData;
    }

    public function checkParam($requestData, $errorNo)
    {
        if (null == $this->get($requestData)) {
            die($this->getError($errorNo));
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
                'error'    => '00000',
                'errorMsg' => 'Unknown error. Contact it.support@ionpay.net.'
            ],
            // General Mandatory parameters
            '01' => [
                'error'    => '10001',
                'errorMsg' => '(timeStamp) is not set. Please set (timeStamp).'
            ],
            '02' => [
                'error'    => '10002',
                'errorMsg' => '(iMid) is not set. Please set (iMid).'
            ],
            '03' => [
                'error'    => '10003',
                'errorMsg' => '(payMethod) is not set. Please set (payMethod).'
            ],
            '04' => [
                'error'    => '10004',
                'errorMsg' => '(currency) is not set. Please set (currency).'
            ],
            '05' => [
                'error'    => '10005',
                'errorMsg' => '(amt) is not set. Please set (amt).'
            ],
            '06' => [
                'error'    => '10006',
                'errorMsg' => '(referenceNo) is not set. Please set (referenceNo).'
            ],
            '07' => [
                'error'    => '10007',
                'errorMsg' => '(goodsNm) is not set. Please set (goodsNm).'
            ],
            '08' => [
                'error'    => '10008',
                'errorMsg' => '(billingNm) is not set. Please set (billingNm).'
            ],
            '09' => [
                'error'    => '10009',
                'errorMsg' => '(billingPhone) is not set. Please set (billingPhone).'
            ],
            '10' => [
                'error'    => '10010',
                'errorMsg' => '(billingEmail) is not set. Please set (billingEmail).'
            ],
            '11' => [
                'error'    => '10011',
                'errorMsg' => '(billingAddr) is not set. Please set (billingAddr).'
            ],
            '12' => [
                'error'    => '10012',
                'errorMsg' => '(billingCity) is not set. Please set (billingCity).'
            ],
            '13' => [
                'error'    => '10013',
                'errorMsg' => '(billingState) is not set. Please set (billingState).'
            ],
            '14' => [
                'error'    => '10014',
                'errorMsg' => '(billingPostCd) is not set. Please set (billingPostCd).'
            ],
            '15' => [
                'error'    => '10015',
                'errorMsg' => '(billingCountry) is not set. Please set (billingCountry).'
            ],
            '16' => [
                'error'    => '10016',
                'errorMsg' => '(deliveryNm) is not set. Please set (deliveryNm).'
            ],
            '17' => [
                'error'    => '10017',
                'errorMsg' => '(deliveryPhone) is not set. Please set (deliveryPhone).'
            ],
            '18' => [
                'error'    => '10018',
                'errorMsg' => '(deliveryAddr) is not set. Please set (deliveryAddr).'
            ],
            '19' => [
                'error'    => '10019',
                'errorMsg' => '(deliveryCity) is not set. Please set (deliveryCity).'
            ],
            '20' => [
                'error'    => '10020',
                'errorMsg' => '(deliveryState) is not set. Please set (deliveryState).'
            ],
            '21' => [
                'error'    => '10021',
                'errorMsg' => '(deliveryPostCd) is not set. Please set (deliveryPostCd).'
            ],
            '22' => [
                'error'    => '10022',
                'errorMsg' => '(deliveryCountry) is not set. Please set (deliveryCountry).'
            ],
            '23' => [
                'error'    => '10023',
                'errorMsg' => '(dbProcessUrl) is not set. Please set (dbProcessUrl).'
            ],
            '24' => [
                'error'    => '10024',
                'errorMsg' => '(vat) is not set. Please set (vat).'
            ],
            '25' => [
                'error'    => '10025',
                'errorMsg' => '(fee) is not set. Please set (fee).'
            ],
            '26' => [
                'error'    => '10026',
                'errorMsg' => '(notaxAmt) is not set. Please set (notaxAmt).'
            ],
            '27' => [
                'error'    => '10027',
                'errorMsg' => '(description) is not set. Please set (description).'
            ],
            '28' => [
                'error'    => '10028',
                'errorMsg' => '(merchantToken) is not set. Please set (merchantToken).'
            ],
            '29' => [
                'error'    => '10029',
                'errorMsg' => '(reqDt) is not set. Please set (reqDt).'
            ],
            '30' => [
                'error'    => '10030',
                'errorMsg' => '(reqTm) is not set. Please set (reqTm).'
            ],
            '34' => [
                'error'    => '10034',
                'errorMsg' => '(userIP) is not set. Please set (userIP).'
            ],
            '35' => [
                'error'    => '10035',
                'errorMsg' => '(cartData) is not set. Please set (cartData).'
            ],
            '36' => [
                'error'    => '10036',
                'errorMsg' => '(mitraCd) is not set. Please set (mitraCd).'
            ],
            '37' => [
                'error'    => '10037',
                'errorMsg' => '(shopId) is not set. Please set (shopId).'
            ],
            '38' => [
                'error'    => '10038',
                'errorMsg' => '(cartData) is not set. Please set (cartData).'
            ],
            '42' => [
                'error'    => '10042',
                'errorMsg' => '(bankCd) is not set. Please set (bankCd).'
            ],
            '43' => [
                'error'    => '10043',
                'errorMsg' => '(payValidDt) is not set. Please set (payValidDt).'
            ],
            '44' => [
                'error'    => '10044',
                'errorMsg' => '(payValidTm) is not set. Please set (payValidTm).'
            ],
            '45' => [
                'error'    => '10045',
                'errorMsg' => '(vacctValidDt) is not set. Please set (vacctValidDt).'
            ],
            '46' => [
                'error'    => '10046',
                'errorMsg' => '(vacctValidTm) is not set. Please set (vacctValidTm).'
            ],
            // Mandatory parameters to Check Order Status
            '47' => [
                'error'    => '10047',
                'errorMsg' => '(tXid) is not set. Please set (tXid).'
            ]
        ];
        return (json_encode($this->oneLiner($error[$id])));
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
