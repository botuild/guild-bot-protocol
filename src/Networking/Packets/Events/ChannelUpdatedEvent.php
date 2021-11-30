<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


class ChannelUpdatedEvent extends ChannelEvent
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'channel_updated',
            'event_name' => 'CHANNEL_UPDATE'
        ];
    }
}