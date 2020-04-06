<?php


namespace Infrastructure\Api\Auth\OAuth2;


interface ClientInterface
{

    /**
     * @return string
     */
    public function accessToken():string;
}
