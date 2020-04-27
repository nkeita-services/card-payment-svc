<?php


namespace App\Rules\CashIn;

use Illuminate\Contracts\Validation\Rule;
use Payment\Wallet\User\Service\Exception\UserNotFoundServiceException;
use Payment\Wallet\User\Service\UserServiceInterface;

class CashInOriginatorRule implements Rule
{
    /**
     * @var UserServiceInterface
     */
    private $walletUserService;

    /**
     * CashInOriginatorRule constructor.
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
        if('User' == $value['originatorType']){
            try {
                $this->walletUserService
                    ->fetchFromUserId($value['originatorId']);
            } catch (UserNotFoundServiceException $e) {
                return false;
            }
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
