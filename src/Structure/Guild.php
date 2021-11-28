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
     * 获取频道ID
     * @return string 频道ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 获取频道名称
     * @return string 频道名称
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 获取频道头像地址
     * @return string 频道头像Url地址
     */
    public function getIconUrl()
    {
        return $this->icon_url;
    }

    /**
     * 获取频道创建者ID
     * @return string 频道创建者ID
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * 获取当前是否是创建人
     * @return bool True OR False
     */
    public function getIsOwner()
    {
        return $this->is_owner;
    }

    /**
     * 获取频道成员数量信息
     * @return CountLimiter 返回最大成员数和当前共有成员数量
     */
    public function getMemberLimiter(): CountLimiter
    {
        return $this->member_limiter;
    }

    /**
     * 获取加入时间
     * @return string 加入时间
     */
    public function getJoinedAt()
    {
        return $this->joined_at;
    }

    /**
     * 获取频道创建者信息
     * @return Member 频道创建者的信息
     */
    public function getOwner()
    {
        return $this->getMember($this->owner_id);
    }

    /**
     * 获取频道用户信息
     * @param $member_id string 用户ID
     * @return Member 获取的用户信息
     */
    public function getMember($member_id)
    {
        return Member::get($member_id, $this, $this->client);

    }

    /**
     * 获取当前所有的用户组
     * @return array 用户组列表
     */
    public function getRoles()
    {
        $roles = $this->client->get('/guilds/' . $this->id . '/roles');
        $parsed_roles = [];
        foreach ($roles['roles'] as $role) {
            array_push($parsed_roles, Role::parse($role));
        }
        return $parsed_roles;
    }

    /**
     * 获取当前所有的子频道
     * @return array 子频道列表
     */
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

    /**
     * 获取子频道信息
     * @param $channel_id string 子频道ID
     * @return Channel 子频道信息
     */
    public function getChannel($channel_id)
    {
        return Channel::get($channel_id, $this->client);
    }
}