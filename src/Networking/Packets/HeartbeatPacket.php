<?php


namespace Botuild\GuildBotProtocol\Networking\Packets;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Packet;
use Exception;

class HeartbeatPacket implements Packet
{
    public $sequence = null;

    public function __construct($sequence)
    {
        $this->sequence = $sequence;
    }

    public static function getPacketInformation(): array
    {
        return [
            'name' => 'Heartbeat',
            'opcode' => 1
        ];
    }

    public static function parse(BasePacket $packet): self
    {
        return new HeartbeatPacket((int)$packet->payload);
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(1);
        $packet->payload = (int)$this->sequence;
        return $packet;
    }
}