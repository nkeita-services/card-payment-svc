<?php


namespace Payment\Account\Collection;


interface AccountCollectionInterface
{

    /**
     * @param array $accounts
     * @return AccountCollectionInterface
     */
    public static function fromArray(array $accounts):AccountCollectionInterface;
    /**
     * @return array
     */
    public function toArray(): array ;

}
