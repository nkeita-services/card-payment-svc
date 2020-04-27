<?php


namespace Infrastructure\CloudRun\Metadata\ProjectID;


interface CloudRunProjectIDInterface
{
    /**
     * @return string
     */
    public function projectId():string;
}
