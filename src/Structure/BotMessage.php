<?php


namespace Botuild\GuildBotProtocol\Structure;


use Botuild\GuildBotProtocol\Networking\Client\ApiClient;

class BotMessage
{
    public ?string $content = null;
    public ?MessageEmbed $embed;
    public ?MessageArk $ark;
    public ?string $image;
    public ?string $target_message;
    public ?ApiClient $client;
    public ?string $channel;

    public function setContent(?string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function setEmbed(?MessageEmbed $embed)
    {
        $this->embed = $embed;
        return $this;
    }

    public function setArk(?MessageArk $ark)
    {
        $this->ark = $ark;
        return $this;
    }

    public function setImage(?string $image)
    {
        $this->image = $image;
        return $this;
    }

    public function attachMessage(Message $message)
    {
        $this->target_message = $message->id;
        $this->channel = $message->channel_id;
        return $this;
    }

    public function attachMessageById($id)
    {
        $this->target_message = $id;
        return $this;
    }

    public function withClient(ApiClient $client)
    {
        $this->client = $client;
        return $this;
    }

    public static function parse($raw)
    {

    }

    public function pack()
    {
        $message = [];
        if (isset($this->content)) $message['content'] = $this->content;
        if (isset($this->embed)) $message['embed'] = $this->embed->pack();
        if (isset($this->ark)) $message['ark'] = $this->ark->pack();
        if (isset($this->image)) $message['image'] = $this->image;
        if (isset($this->target_message)) $message['msg_id'] = $this->target_message;
        return $message;
    }

    public function sendTo(?Channel $channel)
    {
        if ($channel != null) {
            $channel_id = $channel->id;
        } else {
            $channel_id = $this->channel;
        }
        return Message::parse($this->client->post('/channels/' . $channel_id . '/messages', json_encode(
            $this->pack()
        )), $this->client);
    }

    public function send()
    {
        $this->sendTo(null);
    }
}