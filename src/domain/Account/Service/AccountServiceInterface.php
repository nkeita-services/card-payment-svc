<?php


namespace Payment\Account\Service;


use Payment\Account\Entity\AccountEntityInterface;
use Payment\Account\Collection\AccountCollectionInterface;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;

interface AccountServiceInterface
{
    /**
     * @param AccountEntityInterface $accountEntity
     * @param string $userId
     * @param array $organizations
     * @return AccountEntityInterface
     */
    public function create(
        AccountEntityInterface $accountEntity,
        string $userId,
        array $organizations
    ): AccountEntityInterface;

    /**
     * @param string $userId
     * @param array $organizations
     * @return AccountCollectionInterface
     */
    public function fetchAllWithUserAndOrganizations(
        string $userId,
        array $organizations
    ): AccountCollectionInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @param array $organizations
     * @param array $data
     * @return AccountEntityInterface
     */
    public function updateWithUserAndAccountAndOrganizations(
        string $userId,
        string $accountId,
        array $organizations,
        array $data
    ): AccountEntityInterface;

    /**
     * @param string $accountId
     * @return AccountEntityInterface
     */
    public function fetchWithAccountId(
        string $accountId
    ): AccountEntityInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @return AccountEntityInterface
     */
    public function fetchWithUserIdAndAccountId(
        string $userId,
        string $accountId
    ): AccountEntityInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @param array $organizations
     * @param float $amount
     * @return AccountEntityInterface
     */
    public function topUp(
        string $userId,
        string $accountId,
        array $organizations,
        float $amount
    ): AccountEntityInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @param array $organizations
     * @param float $amount
     * @return AccountEntityInterface
     */
    public function debit(
        string $userId,
        string $accountId,
        array $organizations,
        float $amount
    ): AccountEntityInterface;

    /**
     * @param PaymentIntentInterface $intent
     * @return AccountEntityInterface
     */
    public function topUpFromPaymentIntent(
        PaymentIntentInterface $intent
    ): AccountEntityInterface;
}
