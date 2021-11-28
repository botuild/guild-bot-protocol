<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Structure\Enum\AudioStatus;

class AudioControl
{

    public AudioStatus $status;
    public ?string $audio_url;
    public ?string $text;

    public function __construct(AudioStatus $status, ?string $audio_url, ?string $text)
    {
        $this->status = $status;
        $this->audio_url = $audio_url;
        $this->text = $text;
    }

    public static function parse($raw)
    {
        return new AudioControl(
            AudioStatus::from($raw['status'] ?? 3),
            $raw['audio_url'] ?? null,
            $raw['status'] ?? null
        );
    }

    public function pack()
    {
        return [
            'status' => $this->status->getValue(),
            'audio_url' => $this->audio_url,
            'text' => $this->text
        ];
    }
}