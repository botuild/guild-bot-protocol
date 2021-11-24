<?php


namespace Botuild\GuildBotProtocol\Registry;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Packet;

class EventRegistry
{
    protected array $packets = [];

    public function __construct($packets = [])
    {
        foreach ($packets as $packet) {
            $this->register($packet);
        }
    }

    public function register($packet)
    {
        if (
            (!class_exists($packet) || !is_subclass_of($packet, Packet::class)) and (!$packet instanceof Packet)
        ) {
            throw new TypeError('The type of packet is wrong.Expected implements Packet , but ' . $packet . ' not.');
        }
        $this->packets[$packet::getPacketInformation()['event_name']] = $packet;
    }

    public function resolve(BasePacket $packet)
    {
        if (!isset($this->packets[$packet->payload_type])) {
            return null;
        }
        if (is_string($this->packets[$packet->payload_type]))
            return $this->packets[$packet->payload_type]::parse($packet);
        else
            return $this->packets[$packet->payload_type]->parse($packet);
    }
}