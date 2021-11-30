<?php

namespace Botuild\GuildBotProtocol\Networking\Packets\Events;

class GuildMemberRemovedEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'guild_member_removed',
            'event_name' => 'GUILD_MEMBER_REMOVE'
        ];
    }
}