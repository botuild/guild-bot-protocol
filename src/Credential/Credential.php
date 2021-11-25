<?php


namespace Botuild\GuildBotProtocol\Credential;


interface Credential
{
    public function getAuthorizationPayload(): string;
}