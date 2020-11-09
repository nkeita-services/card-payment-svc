<?php


namespace Payment\MTN\Remittance\Service;


use Payment\MTN\Remittance\Entity\MTNTransferEntityInterface;

interface MTNRemittanceServiceInterface
{

    public function transfer(
        MTNTransferEntityInterface $MTNTransferEntity
    );
}
