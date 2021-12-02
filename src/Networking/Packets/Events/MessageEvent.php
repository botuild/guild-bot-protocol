<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Structure\Message;
use Symfony\Contracts\EventDispatcher\Event;

abstract class MessageEvent extends Event implements Packet
{
    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public static function parse(ApiClient $client, BasePacket $packet): Packet
    {
        $target_class = get_called_class();
        $event = new $target_class(Message::parse($packet->payload, $client));
        return $event;
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(0);
        $packet->payload_type = $this->getPacketInformation()['event_name'];
        return $packet;
    }
}