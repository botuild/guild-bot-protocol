<?php


namespace Botuild\GuildBotProtocol\Credential;


class BotTokenCredential implements Credential
{
    protected $bot_authorization = '';

    /**
     * 初始化机器人信息
     * @param $bot_id integer 由腾讯下发的机器人ID
     * @param $bot_token string 由腾讯下发的机器人TOKEN
     * @return void 初始化过后的信息
     */
    public function __construct($bot_id, $bot_token)
    {
        $this->bot_authorization = 'Bot ' . $bot_id . '.' . $bot_token;
    }

    public function getAuthorizationPayload(): string
    {
        return $this->bot_authorization;
    }
}