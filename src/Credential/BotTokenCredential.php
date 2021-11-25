<?php


namespace Botuild\GuildBotProtocol\Credential;


class BotTokenCredential implements Credential
{
    protected $bot_authorization = '';

    public function __construct($bot_id, $bot_token)
    {
        $this->bot_authorization = 'Bot ' . $bot_id . '.' . $bot_token;
    }

    public function getAuthorizationPayload(): string
    {
        return $this->bot_authorization;
    }
}