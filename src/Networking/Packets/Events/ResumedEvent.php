<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;

class ResumedEvent implements Packet
{
    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'Resumed Packet',
            'event_name' => 'RESUMED'
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet)
    {
        return new ResumedEvent();
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(0);
        $packet->payload_type = 'RESUMED';
        $packet->payload = '';
        return $packet;
    }
}