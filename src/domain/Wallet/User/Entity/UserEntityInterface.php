<?php


namespace Payment\Wallet\User\Entity;


interface UserEntityInterface
{
    /**
     * @return string
     */
    public function getLastName(): string;

    /**
     * @return string
     */
    public function getFirstName(): string;

    /**
     * @return array
     */
    public function getAddress(): array;
    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getPhoneNumber(): string;

    /**
     * @return string
     */
    public function getMobileNumber(): string;

    /**
     * @return string
     */
    public function getLanguage(): string;

    /**
     * @return array
     */
    public function getWalletOrganizations(): array;

    /**
     * @return string
     */
    public function getUserId(): string;
}
