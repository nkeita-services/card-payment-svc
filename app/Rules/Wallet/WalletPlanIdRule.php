<?php


namespace App\Rules\Wallet;

use Illuminate\Contracts\Validation\Rule;
use Wallet\Wallet\Plan\Service\Exception\WalletPlanNotFoundException;
use Wallet\Wallet\Plan\Service\WalletPlanServiceInterface;

class WalletPlanIdRule implements Rule
{
    /**
     * @var WalletPlanServiceInterface
     */
    private $walletPlanService;

    /**
     * WalletPlanIdRule constructor.
     * @param WalletPlanServiceInterface $walletPlanService
     */
    public function __construct(WalletPlanServiceInterface $walletPlanService)
    {
        $this->walletPlanService = $walletPlanService;
    }


    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        try {
            $this
                ->walletPlanService
                ->fromWalletPlanId($value);
        } catch (WalletPlanNotFoundException $e) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return ":attribute is not valid";
    }

}
