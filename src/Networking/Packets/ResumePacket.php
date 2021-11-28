<?php


namespace Botuild\GuildBotProtocol\Networking\Packets;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Packet;

class ResumePacket implements Packet
{

    public $token;
    public $session_id;
    public $sequence;

    public function __construct($token, $session_id, $sequence)
    {
        $this->token = $token;
        $this->session_id = $session_id;
        $this->sequence = $sequence;
    }

    public static function getPacketInformation(): array
    {
        return [
            'name' => 'Resume',
            'opcode' => 6
        ];
    }

    public static function parse(ApiClient $client, BasePacket $packet)
    {
        return new ResumePacket(
            $packet->payload['token'] ?? '',
            $packet->payload['session_id'] ?? '',
            $packet->payload['seq'] ?? ''
        );
    }

    public function pack(): BasePacket
    {
        $packet = new BasePacket(6);
        $packet->payload = [
            'token' => $this->token,
            'session_id' => $this->session_id,
            'seq' => $this->sequence
        ];
        return $packet;
    }
}