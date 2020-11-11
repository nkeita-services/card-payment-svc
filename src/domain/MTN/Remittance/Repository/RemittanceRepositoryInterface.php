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

    /**
     * @param string $referenceId
     * @return string
     */
    public function transferStatus(
        string $referenceId
    ):string;
}
