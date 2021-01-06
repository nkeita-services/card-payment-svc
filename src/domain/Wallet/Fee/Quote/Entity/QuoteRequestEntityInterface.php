<?php


namespace Payment\Wallet\Fee\Quote\Entity;


interface QuoteRequestEntityInterface
{
    /**
     * @param array $data
     * @return QuoteRequestEntityInterface
     */
    public static function fromArray(array $data): QuoteRequestEntityInterface;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function getPaymentMean(): string;

    /**
     * @param string $paymentMean
     * @return QuoteRequestEntityInterface
     */
    public function setPaymentMean(string $paymentMean): QuoteRequestEntityInterface;

    /**
     * @return array
     */
    public function getWalletOrganizations(): array ;

    /**
     * @return array
     */
    public function getRegions(): array ;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @return string
     */
    public function getAccountId(): string;

    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @return string
     */
    public function getOperation(): string;

    /**
     * @return string
     */
    public function getOriginator(): string;

}
