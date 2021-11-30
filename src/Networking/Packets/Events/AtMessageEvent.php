<?php


namespace Botuild\GuildBotProtocol\Networking\Packets\Events;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Structure\Message;
use Symfony\Contracts\EventDispatcher\Event;

class AtMessageEvent extends Event implements Packet
{
    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public static function getPacketInformation(): array
    {
        return [
            'opcode' => 0,
            'name' => 'at_message',
            'event_name' => 'AT_MESSAGE_CREATE'
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet): Packet
    {
        $event = new AtMessageEvent(Message::parse($packet->payload, $client));
        return $event;
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(0);
        return $packet;
    }
}