<?php


namespace Botuild\GuildBotProtocol\Registry;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;
use TypeError;

class PacketRegistry
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
        $this->packets[$packet::getPacketInformation()['opcode']] = $packet;
    }

    public function resolve(ApiClient $client, BasePacket $packet)
    {
        if (!isset($this->packets[$packet->opcode])) {
            return null;
        }
        if (is_string($this->packets[$packet->opcode]))
            return $this->packets[$packet->opcode]::parse($client, $packet);
        else
            return $this->packets[$packet->opcode]->parse($client, $packet);
    }
}