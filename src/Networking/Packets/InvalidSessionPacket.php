<?php

namespace Botuild\GuildBotProtocol\Networking\Packets;

use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Symfony\Contracts\EventDispatcher\Event;

class InvalidSessionPacket extends Event implements Packet
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 9,
            'name' => 'invalid_session'
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet)
    {
        return new InvalidSessionPacket();
    }

    public function pack(): BasePacket
    {
        return new BasePacket(9);
    }

}