<?php


namespace Infrastructure\Api\Rest\Client\MTN\Remittance\Response;


class TransferResponse implements TransferResponseInterface
{
    /**
     * @var string
     */
    private $referenceId;

    /**
     * @var array
     */
    private $data;

    /**
     * RequestToPayResponse constructor.
     * @param string $referenceId
     * @param array|null $data
     */
    public function __construct(
        string $referenceId,
        ?array $data = []
    ){
        $this->referenceId = $referenceId;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
