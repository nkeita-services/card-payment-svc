<?php


namespace Payment\MTN\Collection\Entity;


interface RequestToPayEntityInterface
{
    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @return string
     */
    public function getPartyIdType(): string;

    /**
     * @return string
     */
    public function getPartyId(): string;

    /**
     * @return string
     */
    public function getPayerMessage(): string;

    /**
     * @return string
     */
    public function getPayeeNote(): string;

    /**
     * @return string
     */
    public function getExternalId(): string;

}
