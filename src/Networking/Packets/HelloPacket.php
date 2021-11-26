<?php


namespace Botuild\GuildBotProtocol\Networking\Packets;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;

class HelloPacket implements Packet
{
    public $heartbeat_interval = 1000;

    public function __construct($heartbeat_interval = 1000)
    {
        $this->heartbeat_interval = $heartbeat_interval;
    }

    public static function getPacketInformation(): array
    {
        return [
            'name' => 'Hello',
            'opcode' => 10
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet): self
    {
        return new HelloPacket(
            is_array($packet->payload) && key_exists('heartbeat_interval', $packet->payload) ?
                $packet->payload['heartbeat_interval'] : 1000
        );
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(10);
        $packet->payload = [
            'heartbeat_interval' => $this->heartbeat_interval
        ];
        return $packet;
    }
}