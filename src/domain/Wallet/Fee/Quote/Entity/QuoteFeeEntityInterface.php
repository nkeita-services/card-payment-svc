<?php


namespace Payment\Wallet\Fee\Quote\Entity;


interface QuoteFeeEntityInterface
{
    /**
     * @param array $data
     * @return QuoteFeeEntityInterface
     */
    public static function fromArray(array $data): QuoteFeeEntityInterface;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function getWalletOrganizations(): array;

    /**
     * @return array
     */
    public function getRegions(): array ;

    /**
     * @return array
     */
    public function getPaymentMean(): array;

    /**
     * @return array
     */
    public function getNbk(): array;

}
