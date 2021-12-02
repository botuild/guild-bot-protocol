<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Structure\Message;
use Symfony\Contracts\EventDispatcher\Event;

class AtMessageEvent extends MessageEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'at_message',
            'event_name' => 'AT_MESSAGE_CREATE'
        ];
    }
}