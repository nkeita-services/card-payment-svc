<?php


namespace Payment\MTN\Collection\Service;


interface CollectionServiceInterface
{

    /**
     * @param string $accountId
     * @param float $amount
     * @return mixed
     */
    public function requestToPay(
        string $accountId,
        float $amount
    );
}
