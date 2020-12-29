<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\Mapper\QuoteFeeMapperInterface;
use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\Exception\QuoteFeeNotFoundException;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;

class QuoteFeeApiGuzzleHttpClient implements QuoteFeeApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var QuoteFeeMapperInterface
     */
    private $quoteFeeMapper;

    /**
     * WalletPlanApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param QuoteFeeMapperInterface $quoteFeeMapper
     */
    public function __construct(
        Client $guzzleClient,
        QuoteFeeMapperInterface $quoteFeeMapper){
        $this->guzzleClient = $guzzleClient;
        $this->quoteFeeMapper = $quoteFeeMapper;
    }

    /**
     * @param array $quoteFeePayload
     * @return QuoteFeeEntityInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getQuote(
        array $quoteFeePayload
    ): QuoteFeeEntityInterface
    {
        try {

            $response = $this->guzzleClient->post('/v1/wallets/fees/quote/calculate', [
                RequestOptions::JSON => $quoteFeePayload
            ]);

        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                throw new QuoteFeeNotFoundException(
                    sprintf('Quote not found')
                );
            }

            throw $e;
        }

        return $this
            ->quoteFeeMapper
            ->createQuoteFeeFromApiResponse(
            $response
        );
    }
}
