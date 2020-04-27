<?php


namespace Infrastructure\Secrets;
use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;
use Infrastructure\CloudRun\Metadata\ProjectID\CloudRunProjectIDInterface;
use Infrastructure\Secrets\Exception\NotFoundInEnvironmentVariablesException;

class SecretManager implements SecretManagerInterface
{

    /**
     * @var CloudRunProjectIDInterface
     */
    private $cloudRunMetadata;

    /**
     * @var string
     */
    private $secretName;

    /**
     * @var string
     */
    private $secretVersion;

    /**
     * @var SecretManagerServiceClient
     */
    private $gCloudSecretManagerServiceClient;

    /**
     * SecretManager constructor.
     * @param CloudRunProjectIDInterface $cloudRunMetadata
     * @param string $secretName
     * @param string $secretVersion
     * @param SecretManagerServiceClient $gCloudSecretManagerServiceClient
     */
    public function __construct(
        CloudRunProjectIDInterface $cloudRunMetadata,
        string $secretName,
        string $secretVersion,
        SecretManagerServiceClient $gCloudSecretManagerServiceClient
    ){
        $this->cloudRunMetadata = $cloudRunMetadata;
        $this->secretName = $secretName;
        $this->secretVersion = $secretVersion;
        $this->gCloudSecretManagerServiceClient = $gCloudSecretManagerServiceClient;
    }


    /**
     * @inheritDoc
     */
    public function get(
        string $name
    ): string{

        try {
            return $this->fromEnv(
                $name
            );
        } catch (NotFoundInEnvironmentVariablesException $e) {
        }

        $secretVersionName = $this
            ->gCloudSecretManagerServiceClient
            ->secretVersionName(
            $this->cloudRunMetadata->projectId(),
            $this->secretName,
            $this->secretVersion
        );

        $response = $this
            ->gCloudSecretManagerServiceClient
            ->accessSecretVersion($secretVersionName);

        $data =  json_decode(
            $response->getPayload()->getData(), true
        );

        return $data[$name];
    }

    public function fromEnv(string $name)
    {
        $value =  env($name, getenv($name));

        if(empty($value)){
            throw new NotFoundInEnvironmentVariablesException(
                sprintf('%s not found in environment variables', $name)
            );
        }

        return $value;
    }


}
