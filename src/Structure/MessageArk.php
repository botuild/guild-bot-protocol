<?php


namespace Botuild\GuildBotProtocol\Structure;


class MessageArk
{
    public $template_id;
    public array $map = [];

    public function __construct($template_id, array $map = [])
    {
        $this->template_id = $template_id;
        $this->map = $map;
    }

    public static function parse($raw)
    {
        $map = [];
        foreach ($raw['kv'] ?? [] as $item) {
            if (isset($item['key']))
                $map[$item['key']] = MessageArkMap::parse($item);
        }
        return new MessageArk(
            $raw['template_id'],
            $map
        );
    }

    public function pack()
    {
        $map = [];
        foreach ($raw['kv'] ?? [] as $item) {
            array_push($map, $item->pack());
        }
        return [
            'template_id' => $this->template_id,
            'kv' => $map
        ];
    }
}