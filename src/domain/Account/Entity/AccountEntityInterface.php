<?php


namespace Payment\Account\Entity;


interface AccountEntityInterface
{

    /**
     * @return array
     */
    public function toArray():array;
    /**
     * @return string
     */
    public function getAccountType(): string;

    /**
     * @return float|null
     */
    public function getBalance(): ?float;
    /**
     * @return string|null
     */
    public function getUserId(): ?string;

    /**
     * @return string
     */
    public function getWalletPlanId(): string;

    /**
     * @return array
     */
    public function getOrganizations(): array;

    /**
     * @return string
     */
    public function getAccountId(): string;
}
