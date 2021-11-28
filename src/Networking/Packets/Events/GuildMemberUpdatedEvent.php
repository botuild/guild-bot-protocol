<?php

namespace Botuild\GuildBotProtocol\Networking\Packets\Events;

class GuildMemberUpdatedEvent extends GuildMemberEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'GuildMember Update Event',
            'event_name' => 'GUILD_MEMBER_UPDATE'
        ];
    }
}