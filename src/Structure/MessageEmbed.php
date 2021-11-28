<?php


namespace Botuild\GuildBotProtocol\Structure;


use Carbon\Carbon;

class MessageEmbed
{
    public $title;
    public $description;
    public $prompt;
    public Carbon $timestamp;
    public array $fields = [];

    public function __construct($title, $description, $prompt, $timestamp, $fields = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->prompt = $prompt;
        $this->timestamp = $timestamp;
        $this->fields = $fields;
    }

    public static function parse($raw)
    {
        return new MessageEmbed(
            $raw['title'] ?? '',
            $raw['description'] ?? '',
            $raw['prompt'] ?? null,
            Carbon::parse($raw['timestamp'] ?? '2010-01-01 0:0:0'),
            $raw['fields'] ?? []
        );
    }

    public function pack()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'prompt' => $this->prompt,
            'timestamp' => $this->timestamp->toIso8601String(),
            'fields' => $this->fields
        ];
    }
}