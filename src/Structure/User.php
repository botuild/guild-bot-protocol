<?php


namespace Botuild\GuildBotProtocol\Structure;


class User
{
    public $id;
    public $username;
    public $avatar;
    public $is_bot;
    public $union_open_id;
    public $union_user;

    public function __construct($id, $username, $avatar, $is_bot, $union_open_id, $union_user)
    {
        $this->id = $id;
        $this->username = $username;
        $this->avatar = $avatar;
        $this->is_bot = $is_bot;
        $this->union_open_id = $union_open_id;
        $this->union_user = $union_user;
    }

    public static function parse($raw)
    {
        return new User(
            $raw['id'],
            $raw['username'] ?? '',
            $raw['avatar'] ?? '',
            $raw['bot'] ?? false,
            $raw['union_openid'] ?? null,
            $raw['union_user_account'] ?? null
        );
    }

    public function pack()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'bot' => $this->is_bot,
            'union_openid' => $this->union_open_id,
            'union_user_account' => $this->union_user
        ];
    }
}