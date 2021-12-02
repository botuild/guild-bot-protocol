<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


use Botuild\GuildBotProtocol\Networking\Packet;

class WhisperMessageEvent extends MessageEvent implements Packet
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'whisper_message',
            'event_name' => 'DIRECT_MESSAGE_CREATE'
        ];
    }
}