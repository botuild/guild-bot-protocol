<?php


namespace Botuild\GuildBotProtocol\Structure;


class MessageArkObject
{
    public $object_map = [];

    public function __construct(array $object_map)
    {
        $this->object_map = $object_map;
    }

    public static function parse($raw)
    {
        $object_map = [];
        foreach ($raw['obj_kv'] as $item) {
            $object_map[$item['key']] = $item['value'];
        }
        return new self($object_map);
    }

    public function pack()
    {
        $objects = [];
        foreach ($this->object_map as $key => $value) {
            array_push($objects, ['key' => $key, 'value' => $value]);
        }
        return $objects;
    }

    public function __get($key)
    {
        return $this->object_map[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->object_map[$key] = $value;
    }

}