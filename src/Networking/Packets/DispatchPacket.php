<?php


namespace Botuild\GuildBotProtocol\Networking\Packets;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Networking\Packets\Events\AtMessageEvent;
use Botuild\GuildBotProtocol\Registry\EventRegistry;

class DispatchPacket implements \Botuild\GuildBotProtocol\Networking\Packet
{
    public static EventRegistry $events;

    public static function init()
    {
        self::$events = new EventRegistry([
            AtMessageEvent::class
        ]);
    }

    public static function getPacketInformation(): array
    {
        return [
            'name' => 'Dispatch',
            'opcode' => 0
        ];
    }

    public static function parse(BasePacket $packet)
    {
        return self::$events->resolve($packet);
    }

    public function pack(): BasePacket
    {
        throw new \Exception('The dispatch packet shouldn\'t pack.Please use the Specified Event Packet to send.');
    }
}