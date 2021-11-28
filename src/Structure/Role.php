<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Types\CountLimiter;
use Spatie\Color\Color;
use Spatie\Color\Hex;
use Spatie\Color\Rgba;

class Role
{
    public $id;
    public $name;
    public Rgba $color;
    public bool $hoist;
    public CountLimiter $member_limiter;

    public function __construct($id, $name, Rgba $color, bool $hoist, CountLimiter $member_limiter)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->hoist = $hoist;
        $this->member_limiter = $member_limiter;
    }

    public static function parse($raw)
    {
        $colorStr = str_pad(dechex($raw['color'] ?? 0), 8, '0', STR_PAD_LEFT);
        return new Role(
            $raw['id'],
            $raw['name'] ?? null,
            Hex::fromString('#' . substr($colorStr, 0, 6))->toRgba(hexdec(substr($colorStr, -2)) / 256),
            isset($raw['hoist']) ? $raw['hoist'] == 1 : false,
            new CountLimiter($raw['number'] ?? 0, $raw['member_limit'] ?? 0)
        );
    }

    public function pack()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => hexdec(str_replace('#', '', $this->color->toHex()) . dechex($this->color->alpha()) * 256),
            'hoist' => $this->hoist ? 0 : 1,
            'number' => $this->member_limiter->current,
            'member_limit' => $this->member_limiter->total
        ];
    }
}