<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


class ChannelMessageEvent extends MessageEvent implements \Botuild\GuildBotProtocol\Networking\Packet
{

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'channel_message',
            'event_name' => 'MESSAGE_CREATE'
        ];
    }
}