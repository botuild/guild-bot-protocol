<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Structure\User;
use Botuild\GuildBotProtocol\Types\CountLimiter;
use Symfony\Contracts\EventDispatcher\Event;


class ReadyEvent extends Event implements Packet
{
    public $version;
    public $session_id;
    public User $user;
    public CountLimiter $shard;

    public function __construct($version, $session_id, User $user, CountLimiter $shard)
    {
        $this->version = $version;
        $this->session_id = $session_id;
        $this->user = $user;
        $this->shard = $shard;
    }

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'Ready Event Packet',
            'event_name' => 'READY'
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet)
    {
        return new ReadyEvent(
            $packet->payload['version'],
            $packet->payload['session_id'],
            User::parse($packet->payload['user']),
            new CountLimiter($packet->payload['shard'][0], $packet->payload['shard'][1])
        );
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(0);
        $packet->payload_type = "READY";
        $packet->payload = [
            'version' => $this->version,
            'session_id' => $this->session_id,
            'user' => $this->user->pack(),
            'shard' => [
                $this->shard->current,
                $this->shard->total
            ]
        ];
        return $packet;
    }
}