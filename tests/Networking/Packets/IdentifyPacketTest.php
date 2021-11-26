<?php

namespace Networking\Packets;

use Botuild\GuildBotProtocol\Credential\BotTokenCredential;
use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Intents;
use Botuild\GuildBotProtocol\Networking\Packets\IdentifyPacket;
use PHPUnit\Framework\TestCase;
use Sokil\Bitmap;

class IdentifyPacketTest extends TestCase
{
    public function testInformation()
    {
        $this->assertEquals(IdentifyPacket::getPacketInformation()['opcode'], 2);
    }

    public function testPack()
    {
        $packet = new IdentifyPacket(
            'my_token',
            (new Bitmap())->setBits([
                Intents::GUILD,
                Intents::MEMBER,
                Intents::WHISPER,
                Intents::AUDIO,
                Intents::AT_MESSAGE
            ]),
            0,
            4,
            'my_library'
        );
        $this->assertEquals($packet->pack()->toRaw(), json_decode(<<<EOF
        {
          "op": 2,
          "d": {
            "token": "my_token",
            "intents": 1610616835,
            "shard": [0,4],
            "properties": {
              "\$os": "linux",
              "\$browser": "botuild-protocol",
              "\$device": "my_library"
            }
          }
        }
EOF
            , true));
    }

    public function testParse()
    {
        $packet = IdentifyPacket::parse(new ApiClient(new BotTokenCredential('test', 'test')), BasePacket::fromRaw(json_decode(<<<EOF
        {
          "op": 2,
          "d": {
            "token": "my_token",
            "intents": 1610616835,
            "shard": [0,4],
            "properties": {
              "\$os": "linux",
              "\$browser": "botuild-protocol",
              "\$device": "my_library"
            }
          }
        }
EOF
            , true)));
        $this->assertEquals($packet->token, 'my_token');
        $this->assertEquals($packet->device, 'my_library');
        $this->assertTrue(
            $packet->intents->isBitSet(Intents::GUILD) &&
            $packet->intents->isBitSet(Intents::MEMBER) &&
            $packet->intents->isBitSet(Intents::WHISPER) &&
            $packet->intents->isBitSet(Intents::AUDIO) &&
            $packet->intents->isBitSet(Intents::AT_MESSAGE)
        );
        $this->assertEquals($packet->shard, ['id' => 0, 'total' => 4]);
    }
}
