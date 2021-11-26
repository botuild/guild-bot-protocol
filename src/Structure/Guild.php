<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Types\CountLimiter;
use Carbon\Carbon;

class Guild
{
    protected $id;
    protected $name;
    protected $icon_url;
    protected $owner_id;
    protected $is_owner;
    protected CountLimiter $member_limiter;
    protected $joined_at;
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

    public function withClient(ApiClient $client)
    {
        $this->client = $client;
        return $this;
    }

    public function __get($key)
    {
        $method_name = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        if (method_exists($this, $method_name)) {
            $this->$method_name();
        }
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

    }
}