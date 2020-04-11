<?php


namespace Payment\MTN\Collection\Repository;


use Payment\MTN\Collection\Entity\RequestToPayEntityInterface;

interface CollectionRepositoryInterface
{
    /**
     * @param RequestToPayEntityInterface $requestToPayEntity
     * @return bool
     */
    public function requestToPay(RequestToPayEntityInterface $requestToPayEntity): bool;
}
