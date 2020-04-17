<?php

namespace Infrastructure\Api\Rest\Client\Account;

use Payment\Account\Entity\AccountEntityInterface;
use Payment\Account\Collection\AccountCollectionInterface;

interface AccountApiClientInterface
{
    /**
     * @param string $userId
     * @param string $accountId
     * @return AccountEntityInterface
     */
    public function fetchWithUserIdAndAccountId(
        string $userId,
        string $accountId
    ):AccountEntityInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @param string $amount
     * @param string $description
     * @return AccountEntityInterface
     */
    public function topUpWithUserIdAndAccountId(
        string $userId,
        string $accountId,
        string $amount,
        string $description
    ):AccountEntityInterface;
}
