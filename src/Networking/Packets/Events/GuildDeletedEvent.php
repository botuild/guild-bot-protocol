<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


class GuildDeletedEvent extends GuildEvent
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'guild_deleted',
            'event_name' => 'GUILD_DELETE'
        ];
    }
}