<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote;


use DomainException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
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

            return $this
                ->quoteFeeMapper
                ->createQuoteFeeFromApiResponse(
                    $response
                );

        } catch (ClientException $exception) {

           if($exception->getResponse()->getStatusCode() == 404){

                throw new QuoteFeeNotFoundException(
                    sprintf('Quote not found')
                );
            }

            throw $exception;
        }catch (ServerException $e){
            $decodedPayload = json_decode(
                $e->getResponse()->getBody()->getContents(), true
            );

            throw new QuoteFeeNotFoundException(
                $decodedPayload['StatusDescription']
            );
        }


    }
}
