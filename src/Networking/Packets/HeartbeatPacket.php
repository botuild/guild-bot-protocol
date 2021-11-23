<?php


namespace Botuild\GuildBotProtocol\Networking\Packets;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Packet;

class HeartbeatPacket implements Packet
{

    public static function getPacketInformation(): array
    {
        // TODO: Implement getPacketInformation() method.
        return [

        ];
    }

    public static function parse(BasePacket $packet): self
    {
        // TODO: Implement parse() method.
        return new HeartbeatPacket();
    }

    public function pack(): BasePacket
    {
        // TODO: Implement pack() method.
        return new BasePacket(-1);
    }
}