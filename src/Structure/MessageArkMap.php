<?php


namespace Botuild\GuildBotProtocol\Structure;


class MessageArkMap
{
    public $key;
    public $value;
    public array $objects = [];

    public function __construct($key, $value, array $objects = [])
    {
        $this->key = $key;
        $this->value = $value;
        $this->objects = $objects;
    }

    public static function parse($raw)
    {
        $objects = [];
        foreach ($raw['obj'] ?? [] as $object) {
            array_push($objects, MessageArkObject::parse($object));
        }
        return new MessageArkMap(
            $raw['key'] ?? '',
            $raw['value'] ?? '',
            $objects
        );
    }

    public function pack()
    {
        $objects = [];
        foreach ($this->objects as $object) {
            array_push($objects, $object->pack());
        }
        return [
            'key' => $this->key,
            'value' => $this->value,
            'objects' => $objects
        ];
    }
}