<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Carbon\Carbon;

class Member
{
    public ?User $user = null;
    public ?string $nick = null;
    public array $roles = [];
    public ?Carbon $joined_at;

    public function __construct(?User $user = null, ?string $nick = null, array $roles = [], Carbon $joined_at = null)
    {
        $this->user = $user;
        $this->nick = $nick;
        $this->roles = $roles;
        $this->joined_at = $joined_at;
    }

    public static function parse($raw)
    {
        return new Member(
            isset($raw['user']) ? User::parse($raw['user']) : null,
            $raw['nick'] ?? null,
            $raw['roles'] ?? [],
            Carbon::parse($raw['joined_at'] ?? '2010-01-01 0:0:0')
        );
    }

    public static function get($member_id, Guild $guild, ApiClient $client)
    {
        return self::parse($client->get('/guilds/' . $guild->getId() . '/members/' . $member_id));
    }

    public function attachUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function pack()
    {
        return [
            'user' => $this->user != null ? $this->user->pack() : null,
            'nick' => $this->nick,
            'roles' => $this->roles,
            'joined_at' => $this->joined_at->toIso8601String()
        ];
    }
}