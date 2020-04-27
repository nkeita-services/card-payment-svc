<?php


namespace Infrastructure\Secrets;


interface SecretManagerInterface
{

    /**
     * @param string $name
     * @return string
     */
    public function get(
        string $name
    ):string ;

    /**
     * @param string $name
     * @return mixed
     */
    public function fromEnv(
        string $name
    );
}
