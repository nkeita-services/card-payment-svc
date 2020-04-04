<?php

namespace Infrastructure\Api\Rest\Client\Account;

use Wallet\Account\Entity\AccountEntityInterface;
use Wallet\Wallet\Account\Collection\AccountCollectionInterface;

interface AccountApiClientInterface
{

    /**
     * @param array $accountPayload
     * @return AccountEntityInterface
     */
    public function create(array $accountPayload): AccountEntityInterface;

    /**
     * @param array $filter
     * @return AccountCollectionInterface
     */
    public function fetchAll(array $filter): AccountCollectionInterface;

    /**
     * @param string $accountId
     * @param array $data
     * @return AccountEntityInterface
     */
    public function update(string $accountId, array $data): AccountEntityInterface;

    /**
     * @param string $accountId
     * @return AccountEntityInterface
     */
    public function fetch(string $accountId): AccountEntityInterface;
}
