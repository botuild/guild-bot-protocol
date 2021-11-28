<?php

namespace Botuild\GuildBotProtocol\Networking\Packets\Events;

class GuildMemberAddedEvent extends GuildMemberEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'GuildMember Add Event',
            'event_name' => 'GUILD_MEMBER_ADD'
        ];
    }
}