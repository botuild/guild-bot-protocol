<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Carbon\Carbon;

class Message
{
    public string $id = '';
    public string $channel_id = '';
    public string $guild_id = '';
    public string $content = '';
    public Carbon $timestamp;
    public Carbon $edited_timestamp;
    public bool $mention_everyone = false;
    public Member $author;
    public array $attachments = [];
    public array $embeds = [];
    public array $mentions = [];
    public ?MessageArk $message_ark = null;

    public function __construct(
        string $id, string $channel_id, string $guild_id, string $content, Carbon $timestamp, Carbon $edited_timestamp, bool $mention_everyone, Member $author, array $attachments, array $embeds, array $mentions, ?MessageArk $message_ark)
    {
        $this->id = $id;
        $this->channel_id = $channel_id;
        $this->guild_id = $guild_id;
        $this->content = $content;
        $this->timestamp = $timestamp;
        $this->edited_timestamp = $edited_timestamp;
        $this->mention_everyone = $mention_everyone;
        $this->author = $author;
        $this->attachments = $attachments;
        $this->embeds = $embeds;
        $this->mentions = $mentions;
        $this->message_ark = $message_ark;
    }

    public static function parse($raw, ApiClient $client)
    {
        $author = Member::parse($raw['member'])->attachUser(User::parse($raw['author']));
        $attachments = [];
        foreach ($raw['attachments'] ?? [] as $attachment) {
            array_push($attachments, MessageAttachment::parse($attachment));
        }
        $embeds = [];
        foreach ($raw['embeds'] ?? [] as $embed) {
            array_push($embeds, MessageEmbed::parse($embed));
        }
        $mentions = [];
        foreach ($raw['mentions'] ?? [] as $mention) {
            array_push($mentions, User::parse($mention));
        }
        return new Message(
            $raw['id'] ?? '',
            $raw['channel_id'] ?? '',
            $raw['guild_id'] ?? '',
            $raw['content'] ?? '',
            Carbon::parse($raw['timestamp'] ?? '2010-01-01 0:0:0'),
            Carbon::parse($raw['edited_timestamp'] ?? '2010-01-01 0:0:0'),
            $raw['mention_everyone'] ?? false,
            $author,
            $attachments,
            $embeds,
            $mentions,
            isset($raw['ark']) ? MessageArk::parse($raw['ark']) : null
        );
    }
}