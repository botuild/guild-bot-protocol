<?php

namespace Botuild\GuildBotProtocol\Networking\Packets\Events;

class ChannelDeletedEvent extends ChannelEvent
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'channel_deleted',
            'event_name' => 'CHANNEL_DELETE'
        ];
    }
}