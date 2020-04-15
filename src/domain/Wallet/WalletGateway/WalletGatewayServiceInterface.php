<?php


namespace Payment\Wallet\WalletGateway;


use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;

interface WalletGatewayServiceInterface
{

    /**
     * @param string $userId
     * @param string $accountId
     * @return WalletPlanEntityInterface
     */
    public function walletPlanFromUserIdAndAccountId(
        string $userId,
        string $accountId
    ): WalletPlanEntityInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @return string
     */
    public function accountCurrencyFromUserIdAndAccountId(
        string $userId,
        string $accountId
    ):string;

    /**
     * @param string $userId
     * @return string
     */
    public function phoneNumberFromUserId(
        string $userId
    ):string ;

    /**
     * @param string $userId
     * @return string
     */
    public function mobileNumberFromUserId(
        string $userId
    ):string ;
}
