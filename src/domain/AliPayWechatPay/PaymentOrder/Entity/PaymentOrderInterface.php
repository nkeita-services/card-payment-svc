<?php


namespace Payment\AliPayWechatPay\PaymentOrder\Entity;


interface PaymentOrderInterface
{
    const ALIPAY_SERVICE = 'pay.alipay.native.intl';
    const ALIPAY_WAPPAY_SERVICE = 'pay.alipay.wappay.intl';
    const WECHATPAY_SERVICE = 'pay.weixin.native.intl';
    const WECHAT_ACCOUNT_PAY_SERVICE = 'pay.weixin.jspay';
    const WECHAT_APP_PAY_SERVICE = 'pay.weixin.raw.app';
    const BUSINESS_ALIPAY_WECHATPAY_SERVICE = 'unified.trade.micropay';

    /**
     * @return string
     */
    public function getService() : string ;

    /**
     * @param string $service
     * @return PaymentOrderInterface
     */
    public function setService(string $service) : PaymentOrderInterface;

    /**
     * @return string
     */
    public function getMchId() : string;

    /**
     * @return string
     */
    public function getOutTradeNo() : string;

    /**
     * @return string
     */
    public function getBody() : string;

    /**
     * @return string
     */
    public function getTotalFee() : string;

    /**
     * @return string
     */
    public function getMchCreateIp() : string;

    /**
     * @return string
     */
    public function getNotifyUrl() : string;

    /**
     * @return string
     */
    public function getTimeStart() : string;

    /**
     * @return string
     */
    public function getTimeExpire() : string;

    /**
     * @return string
     */
    public function getNonceStr() : string;

    /**
     * @return string
     */
    public function getKey() : string;

    /**
     * @return string
     */
    public function getSubOpenid() : ?string;

    /**
     * @return string
     */
    public function getSubAppId() : ?string;

    /**
     * @return string
     */
    public function getAuthCode() : ?string;

    /**
     * @return string
     */
    public function getAppId() : ?string;

    /**
     * @return array
     */
    public function toArray(): array;

}
