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
     * @var array
     */
    private $token;



    /**
     * Client constructor.
     * @param string $clientId
     * @param array $scopes
     * @param stdClass $token
     */
    private function __construct(
        string $clientId,
        array $scopes,
        stdClass $token
    )
    {
        $this->clientId = $clientId;
        $this->scopes = $scopes;
        $this->token = $token;
    }

    /**
     * @inheritDoc
     */
    public static function createFromAccessToken(stdClass $accessToken): ClientInterface
    {
        return new static(
            $accessToken->client_id,
            explode(' ', $accessToken->scope),
            $accessToken
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

    /**
     * @inheritDoc
     */
    public function groups(): array
    {
        if(array_key_exists('cognito:groups', $this->token)){
            return array_map(
                function ($groupName){
                    return strtolower($groupName);
                },
                $this->token->{'cognito:groups'}
            );
        }

        return ['user'];
    }

    /**
     * @inheritDoc
     */
    public function memberOf(array $groups): bool
    {
        $matches = array_intersect(
            $this->groups(),
            $groups
        );

        return count($matches) > 0 ? true : false;
    }



}
