<?php


namespace Infrastructure\Api\Consumer\Authorization\OpenID;

use stdClass;
interface ClientInterface
{

    /**
     * @param stdClass $accessToken
     * @return ClientInterface
     */
    public static function createFromAccessToken(stdClass $accessToken):ClientInterface;

    /**
     * @param string $scope
     * @return bool
     */
    public function hasScope(string $scope):bool;

    /**
     * @return array
     */
    public function getOrganizations(): array;

    /**
     * @return array
     */
    public function groups():  array;

    /**
     * @param array $groups
     * @return true
     */
    public function memberOf(array $groups): bool;
}
