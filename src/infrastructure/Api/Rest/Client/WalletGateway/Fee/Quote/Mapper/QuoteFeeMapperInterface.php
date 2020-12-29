<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\Mapper;


use Psr\Http\Message\ResponseInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;

interface QuoteFeeMapperInterface
{
    /**
     * @param ResponseInterface $response
     * @return QuoteFeeEntityInterface
     */
    public function createQuoteFeeFromApiResponse(
        ResponseInterface $response
    ):QuoteFeeEntityInterface;

}
