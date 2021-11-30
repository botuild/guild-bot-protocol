<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


class GuildCreatedEvent extends GuildEvent
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'guild_created',
            'event_name' => 'GUILD_CREATE'
        ];
    }
}