<?php


namespace Infrastructure\Api\Rest\Client\MTN\Remittance\Response;


interface TransferResponseInterface
{
    /**
     * @return string
     */
    public function getReferenceId(): string;

    /**
     * @inheritDoc
     */
    public function getData(): array;
}
