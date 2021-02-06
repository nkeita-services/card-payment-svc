<?php


namespace Infrastructure\Api\Soap\Client\AliPayWechatPay;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrderInterface;
use SimpleXMLElement;
libxml_use_internal_errors(TRUE);

class PaymentOrderApiGuzzleHttpClient implements PaymentOrderApiClientInterface
{

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $key;

    /**
     * WalletPlanApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param string $key
     */
    public function __construct(
        Client $guzzleClient
        //string $key
    ){
        $this->guzzleClient = $guzzleClient;
        //$this->key = $key;
    }

    /**
     * @param PaymentOrderInterface $paymentOrder
     * @return array
     */
    public function createPaymentOrder(
        PaymentOrderInterface $paymentOrder
    ): array{

        $paymentOrderPayload = $paymentOrder->toArray();

        if (!is_null($paymentOrder->getAppId()))
        {
            $paymentOrderPayload['appid'] = $paymentOrder->getAppId();
        }

        if (!is_null($paymentOrder->getAuthCode()))
        {
            $paymentOrderPayload['auth_code'] = $paymentOrder->getAuthCode();
        }

        if (!is_null($paymentOrder->getSubOpenid()))
        {
            $paymentOrderPayload['sub_openid'] = $paymentOrder->getSubOpenid();
        }

        if (!is_null($paymentOrder->getSubAppId()))
        {
            $paymentOrderPayload['sub_appid'] = $paymentOrder->getSubAppId();
        }

        $toSort = $paymentOrderPayload;
        ksort($toSort);
        $signString = http_build_query($toSort);
        $stringTosign = sprintf('%s&key=%s',
            trim($signString),
            trim($paymentOrder->getKey())
            //trim($this->key)
        );


        $paymentOrderPayload['notify_url'] = urlencode($paymentOrderPayload['notify_url']);

       /* dd(
            [
            'a' => $stringTosign,
                'b' =>  $paymentOrderPayload
            ]
        );*/
        $paymentOrderPayload['sign'] = strtoupper(md5($stringTosign));



        try {
            $Response = $this->guzzleClient->post(
                '/pay/gateway',
                [
                    RequestOptions::HEADERS =>[
                        'ContentT-ype' => 'text/xml; charset=UTF8',
                    ],
                    RequestOptions::BODY => $this->arrayToXml($paymentOrderPayload)
                ]
            );

            $res = $Response->getBody()->getContents();

            $xmlObject = simplexml_load_string($res);

        } catch (GuzzleException $e) {

        }

        $array = [];
        foreach ($xmlObject->children() as $node) {
            $array[$node->getName()] = is_array($node) ? simplexml_to_array($node) : (string) $node;
        }

        return collect($array)->toArray();
    }

    function arrayToXml($array, $rootElement = null, $xml = null)
    {
        $xmlContent = $xml;

        if ($xmlContent === null) {
            $xmlContent = new SimpleXMLElement(
                $rootElement !== null ? $rootElement : '<xml/>'
            );
        }

        foreach ($array as $k => $v)
        {
            $xmlContent->addChild($k, $v);
        }

        return $xmlContent->asXML();
    }
}
