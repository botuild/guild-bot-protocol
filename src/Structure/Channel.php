<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Structure\Enum\ChannelSubType;
use Botuild\GuildBotProtocol\Structure\Enum\ChannelType;

class Channel
{
    public $id;
    public $guild_id;
    public $name;
    public ChannelType $type;
    public $sub_type;
    public $order;
    public $group_id;
    public $owner_id;
    protected ApiClient $client;

    public function __construct($id, $guild_id, $name, ChannelType $type, ChannelSubType $sub_type, $order, $group_id, $owner_id)
    {
        $this->id = $id;
        $this->guild_id = $guild_id;
        $this->name = $name;
        $this->type = $type;
        $this->sub_type = $sub_type;
        $this->order = $order;
        $this->group_id = $group_id;
        $this->owner_id = $owner_id;
    }

    public static function parse($raw)
    {
        return new Channel(
            $raw['id'],
            $raw['guild_id'],
            $raw['name'],
            ChannelType::from($raw['type']),
            ChannelSubType::from($raw['sub_type']),
            $raw['position'],
            $raw['parent_id'],
            $raw['owner_id']
        );
    }

    public static function get($channel_id, ApiClient $client)
    {
        return self::parse($client->get('/channels/' . $channel_id));
    }

    public function pack()
    {
        return [
            'id' => $this->id,
            'guild_id' => $this->guild_id,
            'name' => $this->name,
            'type' => $this->type->getValue(),
            'sub_type' => $this->sub_type->getValue(),
            'position' => $this->order,
            'parent_id' => $this->group_id,
            'owner_id' => $this->owner_id
        ];
    }

}