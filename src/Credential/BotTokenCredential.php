<?php


namespace Botuild\GuildBotProtocol\Credential;


class BotTokenCredential implements Credential
{
    protected $bot_authorization = '';

    /**
     * 初始化机器人信息
     * @param $bot_id integer 由腾讯下发的机器人ID
     * @param $bot_token string 由腾讯下发的机器人TOKEN
     * @return void
     */
    public function __construct($bot_id, $bot_token)
    {
        $this->bot_authorization = 'Bot ' . $bot_id . '.' . $bot_token;
    }

    /**
     * 读取授权负载(HTTP Authorization字段/Identify包的Token)
     * @return string
     */
    public function getAuthorizationPayload(): string
    {
        return $this->bot_authorization;
    }
}