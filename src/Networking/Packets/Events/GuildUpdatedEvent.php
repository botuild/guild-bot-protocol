<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


class GuildUpdatedEvent extends GuildEvent
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'Guild Updated Event',
            'event_name' => 'GUILD_UPDATE'
        ];
    }
}