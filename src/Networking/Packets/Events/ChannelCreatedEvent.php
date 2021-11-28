<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


class ChannelCreatedEvent extends ChannelEvent
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'Channel Created Event',
            'event_name' => 'CHANNEL_CREATE'
        ];
    }
}