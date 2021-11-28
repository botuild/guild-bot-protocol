<?php

namespace Botuild\GuildBotProtocol\Networking\Packets\Events;

class ChannelDeletedEvent extends ChannelEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'Channel Deleted Event',
            'event_name' => 'CHANNEL_DELETE'
        ];
    }
}