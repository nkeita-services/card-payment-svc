<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\Mapper;


use Psr\Http\Message\ResponseInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntity;


class QuoteFeeMapper implements QuoteFeeMapperInterface
{
    /**
     * @param ResponseInterface $response
     * @return QuoteFeeEntityInterface
     */
    public function createQuoteFeeFromApiResponse(
        ResponseInterface $response
    ):QuoteFeeEntityInterface
    {
        $quoteFeeData = json_decode(
            $response->getBody()->getContents(),
            true
        );


        return QuoteFeeEntity::fromArray(
            $quoteFeeData['data']['walletQuoteFee']
        );
    }
}
