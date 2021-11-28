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

    /**
     * 设置消息正文
     * @param string|null $content 消息正文
     * @return $this
     */
    public function setContent(?string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * 设置Embed正文
     * @param MessageEmbed|null $embed Embed信息
     * @return $this
     */
    public function setEmbed(?MessageEmbed $embed)
    {
        $this->embed = $embed;
        return $this;
    }

    /**
     * 设置Ark信息正文
     * @param MessageArk|null $ark Ark信息
     * @return $this
     */
    public function setArk(?MessageArk $ark)
    {
        $this->ark = $ark;
        return $this;
    }

    /**
     * 设置图片
     * @param string|null $image 图片Url地址
     * @return $this
     */
    public function setImage(?string $image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * 附件消息
     * @param Message $message 消息对象
     * @return $this
     */
    public function attachMessage(Message $message)
    {
        $this->target_message = $message->id;
        $this->channel = $message->channel_id;
        return $this;
    }

    /**
     * 使用id查找福建消息
     * @param $id integer 消息ID
     * @return $this
     */
    public function attachMessageById($id)
    {
        $this->target_message = $id;
        return $this;
    }

    /**
     * ?
     * @param ApiClient $client 实例化后的ApiClient对象
     * @return $this
     */
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

    /**
     * 消息发送
     * @param Channel|null $channel 频道对象
     * @return Message
     */
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