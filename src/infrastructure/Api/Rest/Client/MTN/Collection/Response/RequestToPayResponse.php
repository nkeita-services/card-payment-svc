<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection\Response;


class RequestToPayResponse implements RequestToPayResponseInterface
{

    /**
     * @var string
     */
    private $referenceId;

    /**
     * RequestToPayResponse constructor.
     * @param string $referenceId
     */
    public function __construct(string $referenceId)
    {
        $this->referenceId = $referenceId;
    }

    /**
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
    }
}
