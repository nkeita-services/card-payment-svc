<?php


namespace Infrastructure\Api\Consumer\Authorization\OpenID;

use stdClass;
use Wallet\Wallet\Organization\Service\OrganizationServiceInterface;

class Client implements ClientInterface
{

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var array
     */
    private $scopes;

    /**
     * Client constructor.
     * @param string $clientId
     * @param array $scope
     */
    private function __construct(string $clientId, array $scope)
    {
        $this->clientId = $clientId;
        $this->scopes = $scope;
    }


    /**
     * @inheritDoc
     */
    public static function createFromAccessToken(stdClass $accessToken): ClientInterface
    {
        return new static(
            $accessToken->client_id,
            explode(' ', $accessToken->scope)
        );
    }

    /**
     * @inheritDoc
     */
    public function hasScope(string $scopeName): bool
    {
        return in_array($scopeName, $this->scopes);
    }

    /**
     * @inheritDoc
     */
    public function getOrganizations(): array
    {
        return [
            app(OrganizationServiceInterface::class)
                ->fromClientIdentifier($this->clientId)
                ->getOrganizationId()
        ];
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }


}
