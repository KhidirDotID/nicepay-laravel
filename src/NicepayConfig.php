<?php

namespace KhidirDotID\Nicepay;

class NicepayConfig
{
    // Merchant ID
    protected $iMid;

    /**
     * Get Merchant ID
     */
    public function getMerchantId(): string
    {
        return $this->iMid;
    }

    /**
     * Set Merchant ID
     */
    public function setMerchantId(string $iMid): void
    {
        $this->iMid = $iMid;
    }

    // Merchant Key
    protected $merchantKey;

    /**
     * Get Merchant Key
     */
    public function getMerchantKey(): string
    {
        return $this->merchantKey;
    }

    /**
     * Set Merchant Key
     */
    public function setMerchantKey(string $merchantKey): void
    {
        $this->merchantKey = $merchantKey;
    }

    // Merchant's result page URL
    protected $callBackUrl;

    /**
     * Get Merchant's result page URL
     */
    public function getCallbackUrl(): string
    {
        return $this->callBackUrl;
    }

    /**
     * Set Merchant's result page URL
     */
    public function setCallbackUrl(string $callBackUrl): void
    {
        $this->callBackUrl = $callBackUrl;
    }

    // Merchant's notification handler URL
    protected $dbProcessUrl;

    /**
     * Get Merchant's notification handler URL
     */
    public function getNotificationUrl(): string
    {
        return $this->dbProcessUrl;
    }

    /**
     * Set Merchant's notification handler URL
     */
    public function setNotificationUrl(string $dbProcessUrl): void
    {
        $this->dbProcessUrl = $dbProcessUrl;
    }

    /* TIMEOUT - Define as needed (in seconds) */
    const NICEPAY_TIMEOUT_CONNECT = 15;
    const NICEPAY_TIMEOUT_READ = 25;

    const NICEPAY_PROGRAM = 'NicepayLite';
    const NICEPAY_VERSION = '1.11';
    const NICEPAY_BUILDDATE = '20160309';

    const NICEPAY_REQ_URL = 'https://www.nicepay.co.id/nicepay/direct/v2/registration';
    const NICEPAY_CANCEL_URL = 'https://www.nicepay.co.id/nicepay/direct/v2/cancel';
    const NICEPAY_ORDER_STATUS_URL = 'https://www.nicepay.co.id/nicepay/direct/v2/inquiry';
    const NICEPAY_ORDER_PAYMENT_URL = 'https://www.nicepay.co.id/nicepay/direct/v2/payment';

    const NICEPAY_REQ_PAYOUT_URL = 'https://dev.nicepay.co.id/nicepay/api/direct/v2/requestPayout';
    const NICEPAY_APPROVE_PAYOUT_URL = 'https://dev.nicepay.co.id/nicepay/api/direct/v2/approvePayout';
    const NICEPAY_REJECT_PAYOUT_URL = 'https://dev.nicepay.co.id/nicepay/api/direct/v2/rejectPayout';
    const NICEPAY_INQUIRY_PAYOUT_URL = 'https://dev.nicepay.co.id/nicepay/api/direct/v2/inquiryPayout';
    const NICEPAY_BALANCE_PAYOUT_URL = 'https://dev.nicepay.co.id/nicepay/api/direct/v2/balanceInquiry';
    const NICEPAY_CANCEL_PAYOUT_URL = 'https://dev.nicepay.co.id/nicepay/api/direct/v2/cancelPayout';
    const NICEPAY_SELLER_BALANCE_URL = 'https://dev.nicepay.co.id/nicepay/direct/v2/sellerBalanceTransfer';
    const NICEPAY_MERCHANT_BALANCE_URL = 'https://dev.nicepay.co.id/nicepay/direct/v2/merchantBalanceTransfer';

    const NICEPAY_READ_TIMEOUT_ERR = '10200';

    /* LOG LEVEL */
    const NICEPAY_LOG_CRITICAL = 1;
    const NICEPAY_LOG_ERROR = 2;
    const NICEPAY_LOG_NOTICE = 3;
    const NICEPAY_LOG_INFO = 5;
    const NICEPAY_LOG_DEBUG = 7;

    // Installment Type
    const CUSTOMER_CHARGE = 1;
    const MERCHANT_CHARGE = 2;

    // Installment Month
    const FULL_PAYMENT = 1;
    const THREE_MONTHS = 3;
    const SIX_MONTHS = 6;
    const NINE_MONTHS = 9;
    const TWELVE_MONTHS = 12;
}
