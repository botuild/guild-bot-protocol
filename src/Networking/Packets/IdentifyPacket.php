<?php


namespace Botuild\GuildBotProtocol\Networking\Packets;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Packet;
use Sokil\Bitmap;

class IdentifyPacket implements Packet
{
    public $token;
    public $intents;
    public $shard;
    public $device;

    public function __construct($token, Bitmap $intents, $shardId = 0, $shardCount = 1, $device = 'botuild')
    {
        $this->token = $token;
        $this->intents = $intents;
        $this->shard = ['id' => $shardId, 'total' => $shardCount];
        $this->device = $device;
    }

    public static function getPacketInformation(): array
    {
        return [
            'name' => 'Identify',
            'opcode' => 2
        ];
    }

    public static function parse(BasePacket $packet): Packet
    {
        return new IdentifyPacket(
            $packet->payload['token'],
            new Bitmap($packet->payload['intents']),
            $packet->payload['shard'][0],
            $packet->payload['shard'][1],
            $packet->payload['properties']['$device']
        );
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(2);
        $packet->payload = [
            'token' => $this->token,
            'intents' => $this->intents->getInt(),
            'shard' => [$this->shard['id'], $this->shard['total']],
            'properties' => [
                '$os' => 'linux',
                '$browser' => 'botuild-protocol 1.0 (By Jason)',
                '$device' => $this->device
            ]
        ];
        return $packet;
    }
}