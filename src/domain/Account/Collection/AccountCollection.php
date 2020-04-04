<?php


namespace Payment\Account\Collection;


use Payment\Account\Entity\AccountEntity;
use Payment\Account\Entity\AccountEntityInterface;

class AccountCollection implements AccountCollectionInterface
{

    /**
     * @var array<AccountEntityInterface>
     */
    private $entities;

    /**
     * AccountCollection constructor.
     * @param array $entities
     */
    public function __construct(array $entities)
    {
        $this->entities = $entities;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $accounts): AccountCollectionInterface
    {
        return new static(
            array_map(function (array $account){
                return AccountEntity::fromArray($account);
            },$accounts)
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_map(function (AccountEntityInterface $accountEntity){
            return $accountEntity->toArray();
        },$this->entities);
    }
}
