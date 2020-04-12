<?php


namespace Payment\MTN\Collection\Service;


interface CollectionServiceInterface
{

    /**
     * @param string $accountId
     * @param float $amount
     * @param string|null $message
     * @param string|null $note
     * @return mixed
     */
    public function requestToPay(
        string $accountId,
        float $amount,
        string $message = null,
        string $note = null
    );
}
