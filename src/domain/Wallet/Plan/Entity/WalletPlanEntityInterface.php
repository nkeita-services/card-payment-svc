<?php


namespace Payment\Wallet\Plan\Entity;


interface WalletPlanEntityInterface
{
    /**
     * @param array $data
     * @return WalletPlanEntityInterface
     */
    public static function fromArray(
        array $data
    ):WalletPlanEntityInterface;

    /**
     * @return string
     */
    public function currency():string;

    /**
     * @param string $name
     * @return mixed
     */
    public function attribute(string $name);

}
