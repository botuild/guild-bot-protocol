<?php

namespace Botuild\GuildBotProtocol\Networking\Packets;

use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;

class InvalidSessionPacket implements Packet
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 9,
            'name' => 'Invalid Session'
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