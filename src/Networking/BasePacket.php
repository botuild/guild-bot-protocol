<?php


namespace Botuild\GuildBotProtocol\Networking;


use Symfony\Contracts\EventDispatcher\Event;

class BasePacket extends Event
{
    public $opcode;
    public $payload;
    public $payload_type;
    public $sequence;

    /**
     * 创建一个新的BasePacket实例
     * @param int $opcode 操作码(op)
     * @param null $payload 负载(d)
     * @param null $payload_type 负载类型(事件类型)(t)
     * @param null $sequence 包序列号(s)
     */
    public function __construct(int $opcode, $payload = null, $payload_type = null, $sequence = null)
    {
        $this->opcode = $opcode;
        $this->payload = $payload;
        $this->payload_type = $payload_type;
        $this->sequence = $sequence;
    }

    /**
     * 从原始数据中解码为一个BasePacket
     * @param array $raw
     * @return BasePacket
     */
    public static function fromRaw(array $raw): BasePacket
    {
        $packet = new BasePacket($raw['op']);
        $packet->payload = isset($raw['d']) ? $raw['d'] : null;
        $packet->payload_type = isset($raw['t']) ? $raw['t'] : null;
        $packet->sequence = isset($raw['s']) ? $raw['s'] : null;
        return $packet;
    }

    /**
     * 转为原始数据
     * @return array
     */
    public function toRaw(): array
    {
        $raw = [];
        $raw['op'] = $this->opcode;
        if ($this->payload !== null) $raw['d'] = $this->payload;
        if ($this->payload_type !== null) $raw['t'] = $this->payload_type;
        if ($this->sequence !== null) $raw['s'] = $this->sequence;
        return $raw;
    }
}