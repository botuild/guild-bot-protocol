<?php


namespace Botuild\GuildBotProtocol\Structure;


class MessageAttachment
{
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public static function parse($raw)
    {
        return new MessageAttachment($raw['url']);
    }

    public function pack()
    {
        return [
            "url" => $this->url
        ];
    }
}