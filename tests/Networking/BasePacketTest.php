<?php

namespace Networking;

use Botuild\GuildBotProtocol\Networking\BasePacket;
use PHPUnit\Framework\TestCase;

class BasePacketTest extends TestCase
{

    public function testFromRaw()
    {
        $packet = BasePacket::fromRaw([
            "op" => 0,
            "d" => [],
            "s" => 42,
            "t" => "GATEWAY_EVENT_NAME"
        ]);
        $this->assertEquals($packet->opcode, 0, 'Opcode parse failed.');

        $this->assertEquals($packet->payload, [], 'Payload parse failed.');

        $this->assertEquals($packet->payload_type, 'GATEWAY_EVENT_NAME', 'Payload type parse failed.');

        $this->assertEquals($packet->sequence, 42, 'Sequence parse failed.');
    }

    public function testToRaw()
    {
        $packet = new BasePacket(0);
        $packet->payload = [];
        $packet->sequence = 42;
        $packet->payload_type = "GATEWAY_EVENT_NAME";
        $this->assertEquals($packet->toRaw(), [
            "op" => 0,
            "d" => [],
            "s" => 42,
            "t" => "GATEWAY_EVENT_NAME"
        ], "Packet pack failed.");

    }
}
