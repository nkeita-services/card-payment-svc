<?php


namespace Payment\MTN\Collection\Service;


interface CollectionServiceInterface
{

    /**
     * @param string $accountId
     * @param float $amount
     * @param array $originator
     * @param string|null $message
     * @param string|null $note
     * @return string
     */
    public function requestToPay(
        string $accountId,
        float $amount,
        array $originator,
        string $message = null,
        string $note = null
    ): string;
}
