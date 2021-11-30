<?php

namespace Botuild\GuildBotProtocol\Networking\Packets;

use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;
use Symfony\Contracts\EventDispatcher\Event;

class ReconnectPacket extends Event implements Packet
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 7,
            'name' => 'reconnect'
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet)
    {
        return new ReconnectPacket();
    }

    public function pack(): BasePacket
    {
        return new BasePacket(7);
    }

}