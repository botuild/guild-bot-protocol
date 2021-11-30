<?php

namespace Botuild\GuildBotProtocol\Networking\Packets\Events;

class GuildMemberAddedEvent extends GuildMemberEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'guild_member_added',
            'event_name' => 'GUILD_MEMBER_ADD'
        ];
    }
}