<?php

namespace Botuild\GuildBotProtocol\Networking\Packets\Events;

class GuildMemberRemovedEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'GuildMember Remove Event',
            'event_name' => 'GUILD_MEMBER_REMOVE'
        ];
    }
}