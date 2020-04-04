<?php


namespace Payment\Account\Entity;


class AccountEntity implements AccountEntityInterface
{
    /**
     * @var string
     */
    private $accountType;

    /**
     * @var float|null
     */
    private $balance;

    /**
     * @var string|null
     */
    private $userId;

    /**
     * @var string
     */
    private $walletPlanId;

    /**
     * @var array
     */
    private $organizations;

    /**
     * @var string
     */
    private $accountId;

    /**
     * AccountEntity constructor.
     * @param string $accountType
     * @param float|null $balance
     * @param string|null $userId
     * @param string $walletPlanId
     * @param string $accountId
     * @param array $organizations
     */
    public function __construct(
        string $accountType = null,
        float $balance = 0,
        string $userId = null,
        string $walletPlanId = null,
        string $accountId = null,
        array $organizations = null)
    {
        $this->accountType = $accountType;
        $this->balance = $balance;
        $this->userId = $userId;
        $this->walletPlanId = $walletPlanId;
        $this->organizations = $organizations;
        $this->accountId = $accountId;
    }


    public static function fromArray(array $data): AccountEntityInterface
    {
        return new static(
            $data['accountType'] ?? 'regular',
            $data['balance'] ?? 0,
            $data['userId'] ?? null,
            $data['walletPlanId'] ?? null,
            $data['accountId'] ?? null,
            $data['organizations'] ?? null
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'accountType' => $this->accountType,
            'userId' => $this->userId,
            'balance' => $this->balance,
            'accountId' => $this->accountId,
            'walletPlanId'=>$this->walletPlanId,
            'organizations'=>$this->organizations
        ];
    }

    /**
     * @return string
     */
    public function getAccountType(): string
    {
        return $this->accountType;
    }

    /**
     * @return float|null
     */
    public function getBalance(): ?float
    {
        return $this->balance;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getWalletPlanId(): string
    {
        return $this->walletPlanId;
    }

    /**
     * @return array
     */
    public function getOrganizations(): array
    {
        return $this->organizations;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }
}
