<?php


namespace App\Rules\CashIn;

use Illuminate\Contracts\Validation\Rule;
use Payment\Account\Service\AccountServiceInterface;
use Exception;

class CashInOriginatorAccountRule implements Rule
{
    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * WalletAccountBelongToUserRule constructor.
     * @param AccountServiceInterface $accountService
     */
    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }


    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        if('User' == $value['originatorType']){
            try {
                $this
                    ->accountService
                    ->fetchWithUserIdAndAccountId(
                        $value['originatorId'],
                        $value['accountId']
                    );
            } catch (Exception $e) {
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
        return "account doesn't match user";
    }

}
