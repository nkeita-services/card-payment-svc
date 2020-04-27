<?php


namespace Infrastructure\CloudRun\Metadata\OAuth\IDToken;


interface OAuthIDTokenServiceInterface
{
    /**
     * @param string $audience
     * @return string
     */
    public function token(
        string $audience
    ): string;
}
