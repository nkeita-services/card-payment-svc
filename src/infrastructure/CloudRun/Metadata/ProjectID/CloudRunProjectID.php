<?php


namespace Infrastructure\CloudRun\Metadata\ProjectID;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class CloudRunProjectID implements CloudRunProjectIDInterface
{

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $defaultProjectId;

    /**
     * CloudRunMetadata constructor.
     * @param Client $guzzleClient
     * @param string $defaultProjectId
     */
    public function __construct(
        Client $guzzleClient,
        string $defaultProjectId)
    {
        $this->guzzleClient = $guzzleClient;
        $this->defaultProjectId = $defaultProjectId;
    }


    /**
     * @inheritDoc
     */
    public function projectId(): string
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/computeMetadata/v1/project/project-id')
            );
        } catch (ConnectException $exception) {
            return $this
                ->defaultProjectId;
        }

        return $response
            ->getBody()
            ->getContents();
    }
}
