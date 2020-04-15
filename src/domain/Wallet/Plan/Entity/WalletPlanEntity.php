<?php


namespace Payment\Wallet\Plan\Entity;

use DomainException;


class WalletPlanEntity implements WalletPlanEntityInterface
{

    /**
     * @var array
     */
    protected $walletPlan;

    /**
     * WalletPlanEntity constructor.
     * @param array $walletPlan
     */
    public function __construct(
        array $walletPlan
    ){
        $this->walletPlan = $walletPlan;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(
        array $data
    ):WalletPlanEntityInterface{
        return new static(
            $data
        );
    }

    /**
     * @inheritDoc
     */
    public function currency():string{
        return $this->attribute('currency');
    }

    /**
     * @inheritDoc
     */
    public function attribute(string $name)
    {
        if(!array_key_exists($name, $this->walletPlan)){
            throw new DomainException(
                sprintf("attribute %s not found", $name)
            );
        }
        return $this->walletPlan[$name];
    }
}
