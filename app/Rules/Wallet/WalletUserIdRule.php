<?php


namespace App\Rules\Wallet;

use Illuminate\Contracts\Validation\Rule;
use Wallet\Wallet\User\Service\Exception\UserNotFoundException;
use Wallet\Wallet\User\Service\UserServiceInterface;
use Exception;

class WalletUserIdRule implements Rule
{
    /**
     * @var UserServiceInterface
     */
    private $walletUserService;

    /**
     * WalletUserIdRule constructor.
     * @param UserServiceInterface $walletUserService
     */
    public function __construct(UserServiceInterface $walletUserService)
    {
        $this->walletUserService = $walletUserService;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        try {
            $this
                ->walletUserService
                ->fetch(
                    $value
                );
        } catch (UserNotFoundException | Exception $e) {
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
