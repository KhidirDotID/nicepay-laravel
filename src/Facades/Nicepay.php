<?php

namespace KhidirDotID\Nicepay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getMerchantId()
 * @method static string getMerchantKey()
 * @method static string getCallbackUrl()
 * @method static string getNotificationUrl()
 * @method static string get(string $name)
 * @method static void set(string $name, string $value)
 * @method static void setMerchantId(string $merchandId)
 * @method static void setMerchantKey(string $merchantKey)
 * @method static void setCallbackUrl(string $callbackUrl)
 * @method static void setNotificationUrl(string $notificationUrl)
 * @method static mixed requestCC(array $requestData)
 * @method static mixed requestVA(array $requestData)
 * @method static mixed requestCVS(array $requestData)
 * @method static mixed requestClickPay(array $requestData)
 * @method static mixed requestEWallet(array $requestData)
 * @method static mixed requestPayloan(array $requestData)
 * @method static mixed requestQris(array $requestData)
 * @method static mixed checkPaymentStatus(string $tXid, string $referenceNo, int $amt)
 * @method static mixed cancelTrans(string $tXid, int $amt)
 * @method static mixed requestPayout(int $amt, int $accountNo)
 * @method static mixed approvePayout(string $tXid)
 * @method static mixed rejectPayout(string $tXid)
 * @method static mixed inquiryPayout(string $tXid, int $accountNo)
 * @method static mixed balanceInquiry()
 * @method static mixed cancelPayout(string $tXid)
 */
class Nicepay extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'nicepay';
    }
}
