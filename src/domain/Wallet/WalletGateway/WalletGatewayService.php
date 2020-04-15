<?php


namespace Payment\Wallet\WalletGateway;


use Payment\Account\Service\AccountServiceInterface;
use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;
use Payment\Wallet\Plan\Service\WalletPlanServiceInterface;
use Payment\Wallet\User\Service\UserServiceInterface;

class WalletGatewayService implements WalletGatewayServiceInterface
{

    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var WalletPlanServiceInterface
     */
    private $walletPlanService;

    /**
     * WalletGatewayService constructor.
     * @param AccountServiceInterface $accountService
     * @param UserServiceInterface $userService
     * @param WalletPlanServiceInterface $walletPlanService
     */
    public function __construct(
        AccountServiceInterface $accountService,
        UserServiceInterface $userService,
        WalletPlanServiceInterface $walletPlanService){
        $this->accountService = $accountService;
        $this->userService = $userService;
        $this->walletPlanService = $walletPlanService;
    }


    /**
     * @inheritDoc
     */
    public function walletPlanFromUserIdAndAccountId(
        string $userId,
        string $accountId
    ): WalletPlanEntityInterface{
        $account = $this
            ->accountService
            ->fetchWithUserIdAndAccountId(
                $userId,
                $accountId
            );

        return $this
            ->walletPlanService
            ->fromWalletPlanId($account->getWalletPlanId());
    }

    /**
     * @inheritDoc
     */
    public function accountCurrencyFromUserIdAndAccountId(
        string $userId,
        string $accountId
    ): string{

        $walletPlan = $this
            ->walletPlanFromUserIdAndAccountId($userId,$accountId);

        return $walletPlan->currency();
    }

    /**
     * @inheritDoc
     */
    public function phoneNumberFromUserId(string $userId): string
    {
        $user= $this
            ->userService
            ->fetchFromUserId($userId);

        return $user->getPhoneNumber();
    }

    /**
     * @inheritDoc
     */
    public function mobileNumberFromUserId(
        string $userId
    ): string{
        $user= $this
            ->userService
            ->fetchFromUserId($userId);

        return $user->getMobileNumber();
    }
}
