<?php


namespace Botuild\GuildBotProtocol\Networking;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;

interface Packet
{
    public static function getPacketInformation(): array;

    public static function parse(ApiClient $client, BasePacket $packet);

    public function pack(): BasePacket;
}