<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Types\CountLimiter;
use Botuild\GuildBotProtocol\Util\GetterMapper;
use Carbon\Carbon;

class Guild
{
    use GetterMapper;
    protected $id;
    protected $name;
    protected $icon_url;
    protected $owner_id;
    protected $is_owner;
    protected CountLimiter $member_limiter;
    protected Carbon $joined_at;
    protected ApiClient $client;

    public function __construct($id, $name, $icon_url, $owner_id, $is_owner, $member_limiter, $joined_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon_url = $icon_url;
        $this->owner_id = $owner_id;
        $this->is_owner = $is_owner;
        $this->member_limiter = $member_limiter;
        $this->joined_at = $joined_at;
    }

    public static function parse($raw, ApiClient $client)
    {
        return (new Guild(
            $raw['id'],
            $raw['name'] ?? null,
            $raw['icon'] ?? null,
            $raw['owner_id'] ?? null,
            $raw['is_owner'] ?? null,
            new CountLimiter($raw['member_count'] ?? 0, $raw['max_members'] ?? 0),
            Carbon::parse($raw['joined_at'] ?? '2010-01-01 0:0:0')
        ))->withClient($client);
    }

    public static function get($id, ApiClient $client)
    {
        return self::parse($client->get('/guilds/' . $id), $client);
    }

    public function pack()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_id' => $this->owner_id,
            'is_owner' => $this->is_owner,
            'member_count' => $this->member_limiter->current,
            'max_members' => $this->member_limiter->total,
            'joined_at' => $this->joined_at->toIso8601String()
        ];
    }

    public function withClient(ApiClient $client)
    {
        $this->client = $client;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getIconUrl()
    {
        return $this->icon_url;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @return mixed
     */
    public function getIsOwner()
    {
        return $this->is_owner;
    }

    /**
     * @return CountLimiter
     */
    public function getMemberLimiter(): CountLimiter
    {
        return $this->member_limiter;
    }

    /**
     * @return mixed
     */
    public function getJoinedAt()
    {
        return $this->joined_at;
    }

    public function getOwner()
    {
        return $this->getMember($this->owner_id);
    }

    public function getMember($member_id)
    {
        return Member::get($member_id, $this, $this->client);

    }

    public function getRoles()
    {
        $roles = $this->client->get('/guilds/' . $this->id . '/roles');
        $parsed_roles = [];
        foreach ($roles['roles'] as $role) {
            array_push($parsed_roles, Role::parse($role));
        }
        return $parsed_roles;
    }

    public function getChannels()
    {
        $channels_raw = $this->client->get('/guilds/' . $this->id . '/channels');
        $channels = [];
        foreach ($channels_raw as $channel) {
            try {
                array_push($channels, Channel::parse($channel, $this->client));
            } catch (\Exception $exception) {
                continue;
            }
        }
        return $channels;
    }

    public function getChannel($channel_id)
    {
        return Channel::get($channel_id, $this->client);
    }
}