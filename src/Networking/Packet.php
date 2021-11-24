<?php


namespace Botuild\GuildBotProtocol\Networking;


interface Packet
{
    public static function getPacketInformation(): array;

    public static function parse(BasePacket $packet);

    public function pack(): BasePacket;
}