<?php


namespace Payment\MTN\Remittance\Repository;


use Payment\MTN\Remittance\Entity\MTNTransferEntityInterface;

interface RemittanceRepositoryInterface
{

    /**
     * @param MTNTransferEntityInterface $MTNTransferEntity
     * @return string
     */
    public function transfer(
        MTNTransferEntityInterface $MTNTransferEntity
    ):string;
}
