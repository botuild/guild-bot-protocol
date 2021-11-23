<?php


namespace Botuild\GuildBotProtocol\Networking;


class BasePacket
{
    public $opcode;
    public $payload;
    public $payload_type;
    public $sequence;

    public function __construct(int $opcode, $payload = null, $payload_type = null, $sequence = null)
    {
        $this->opcode = $opcode;
        $this->payload = $payload;
        $this->payload_type = $payload_type;
        $this->sequence = $sequence;
    }

    public static function fromRaw(array $raw): BasePacket
    {
        $packet = new BasePacket($raw['op']);
        $packet->payload = isset($raw['d']) ? $raw['d'] : null;
        $packet->payload_type = isset($raw['t']) ? $raw['t'] : null;
        $packet->sequence = isset($raw['s']) ? $raw['s'] : null;
        return $packet;
    }

    public function toRaw()
    {
        $raw = [];
        $raw['op'] = $this->opcode;
        if ($this->payload !== null) $raw['d'] = $this->payload;
        if ($this->payload_type !== null) $raw['t'] = $this->payload_type;
        if ($this->sequence !== null) $raw['s'] = $this->sequence;
        return $raw;
    }
}