<?php


namespace Botuild\GuildBotProtocol\Networking\Packets;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packets\Events\AtMessageEvent;
use Botuild\GuildBotProtocol\Networking\Packets\Events\ReadyEvent;
use Botuild\GuildBotProtocol\Networking\Packets\Events\ResumedEvent;
use Botuild\GuildBotProtocol\Registry\EventRegistry;

class DispatchPacket implements \Botuild\GuildBotProtocol\Networking\Packet
{
    public static EventRegistry $events;

    public static function init()
    {
        self::$events = new EventRegistry([
            AtMessageEvent::class,
            ResumedEvent::class,
            ReadyEvent::class
        ]);
    }

    public static function getPacketInformation(): array
    {
        return [
            'name' => 'Dispatch',
            'opcode' => 0
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet)
    {
        return self::$events->resolve($client, $packet);
    }

    public function pack(): BasePacket
    {
        throw new \Exception('The dispatch packet shouldn\'t pack.Please use the Specified Event Packet to send.');
    }
}