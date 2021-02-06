<?php


namespace Payment\AliPayWechatPay\PaymentOrder\Entity;


class PaymentOrder implements PaymentOrderInterface
{
    const VERSION = '2.0';
    const UNDERS_CORE_DIGIT = "_0123456789";
    const ALPHABET = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const SIGN_TYPE = 'MD5';

    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $mchId;

    /**
     * @var  string
     */
    private $body;

    /**
     * @var string
     */
    private $totalFee;

    /**
     * @var string
     */
    private $mchCreateIp;

    /**
     * @var string
     */
    private $notifyUrl;

    /**
     * @var string
     */
    private $timeStart;

    /**
     * @var string
     */
    private $timeExpire;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $authCode;

    /**
     * @var string
     */
    private $subOpenId;

    /**
     * @var string
     */
    private $subAppId;

    /**
     * @var string
     */
    private $outTradeNo;

    /**
     * @var string
     */
    private $nonceStr;


    /**
     * PaymentOrder constructor.
     * @param string $service
     * @param string $mchId
     * @param string $body
     * @param string $totalFee
     * @param string $mchCreateIp
     * @param string $notifyUrl
     * @param string $key
     * @param string|null $appId
     * @param string|null $authCode
     * @param string|null $subOpenId
     * @param string|null $subAppId
     */
    public function __construct(
        string $service,
        string $mchId,
        string $body,
        string $totalFee,
        string $mchCreateIp,
        string $notifyUrl,
        string $key,
        ?string $appId = null,
        ?string $authCode = null,
        ?string $subOpenId= null,
        ?string $subAppId = null

    ){
        $this->service     = $service;
        $this->mchId       = $mchId;
        $this->body        = $body;
        $this->totalFee    = $totalFee;
        $this->mchCreateIp = $mchCreateIp;
        $this->notifyUrl   = $notifyUrl;
        $this->key         = $key;
        $this->appId       = $appId;
        $this->authCode    = $authCode;
        $this->subOpenId   = $subOpenId;
        $this->subAppId    = $subAppId;
        $this->nonceStr    = $this->setNonceStr();
        $this->outTradeNo  = $this->setOutTradeNo();
    }

    /**
     * @return string
     */
    public function getService() : string
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return PaymentOrderInterface
     */
    public function setService(string $service) : PaymentOrderInterface
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getMchId() : string
    {
        return $this->mchId;
    }

    /**
     * @return string
     */
    public function getOutTradeNo() : string
    {
        return $this->outTradeNo;
    }

    /**
     * @return string
     */
    public function setOutTradeNo() : string
    {
        return $this->randomString(
            32,
            sprintf('%s%s',
                self::UNDERS_CORE_DIGIT,
                self::ALPHABET
            )
        );
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getTotalFee() : string
    {
        return $this->totalFee;
    }

    /**
     * @return string
     */
    public function getMchCreateIp() : string
    {
        return $this->mchCreateIp;
    }

    /**
     * @return string
     */
    public function getNotifyUrl() : string
    {
        return $this->notifyUrl;
    }

    /**
     * @return string
     */
    public function getTimeStart() : string
    {
        return $this->timeStart;
    }

    /**
     * @return string
     */
    public function getTimeExpire() : string
    {
        return $this->timeExpire;
    }

    /**
     * @return string
     */
    public function getNonceStr() : string
    {
        return $this->nonceStr;
    }

    public function setNonceStr() : string
    {
       return $this
            ->randomString(
                16,
                self::ALPHABET
            );
    }

    /**
     * @param int $size
     * @param string $characters
     * @return string
     */
    public function randomString(int $size, string $characters) : string
    {
        $randomString = '';

        for ($i = 0; $i < $size; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    /**
     * @return string
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getSubOpenid() : ?string
    {
        return $this->subOpenId;
    }

    /**
     * @return string
     */
    public function getSubAppId() : ?string
    {
        return $this->subAppId;
    }

    /**
     * @return string
     */
    public function getAuthCode() : ?string
    {
        return $this->authCode;
    }

    /**
     * @return string
     */
    public function getAppId() : ?string
    {
        return $this->appId;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        date_default_timezone_set('Etc/GMT+8');
        return [
            'service' => $this->service,
            'charset' => "UTF-8",
            'version' => self::VERSION,
            'sign_type' => self::SIGN_TYPE,
            'mch_id' => $this->mchId,
            'out_trade_no' => $this->outTradeNo,
            //'device_info' => '',
            'body' => $this->body,
            'total_fee' => $this->totalFee,
            'mch_create_ip' => $this->mchCreateIp,
            'notify_url' => $this->notifyUrl,
           // 'time_start' => date('YmdHis'),
            //'time_expire' => date('YmdHis') + (15 * 60),
            //'op_user_id' => '10001',
            'nonce_str' => $this->nonceStr,
        ];
    }
}
