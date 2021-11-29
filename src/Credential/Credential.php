<?php


namespace Botuild\GuildBotProtocol\Credential;


interface Credential
{
    /**
     * @return string
     */
    public function getAuthorizationPayload(): string;
}