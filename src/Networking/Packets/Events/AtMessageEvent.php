<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;

class AtMessageEvent implements \Botuild\GuildBotProtocol\Networking\Packet
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'At Message',
            'event_name' => 'AT_MESSAGE_CREATE'
        ];
    }

    public static function parse(BasePacket $packet, ApiClient $client): Packet
    {
        $event = new AtMessageEvent();
        return $event;
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(0);
        return $packet;
    }
}