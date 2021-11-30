<?php


namespace Botuild\GuildBotProtocol\Networking\Client;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Networking\Packets\DispatchPacket;
use Botuild\GuildBotProtocol\Networking\Packets\HeartbeatAcknowledgePacket;
use Botuild\GuildBotProtocol\Networking\Packets\HeartbeatPacket;
use Botuild\GuildBotProtocol\Networking\Packets\HelloPacket;
use Botuild\GuildBotProtocol\Networking\Packets\IdentifyPacket;
use Botuild\GuildBotProtocol\Networking\Packets\ResumePacket;
use Botuild\GuildBotProtocol\Registry\PacketRegistry;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Workerman\Connection\AsyncTcpConnection;

class WebsocketClient
{
    public AsyncTcpConnection $connection;
    public PacketRegistry $packets;
    //public $onPacketReceived = null; @Deprecated
    public EventDispatcher $event_dispatcher;
    public ApiClient $client;

    /**
     * WebSocket客户端初始化
     * @param ApiClient $client API客户端
     * @return void
     * @throws \Exception
     */

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
        $address = $this->client->get('/gateway')['url'];
        $parsed_address = parse_url($address);
        $secure_layer_transport = false;
        if ($parsed_address['scheme'] === 'wss') {
            $parsed_address['scheme'] = 'ws';
            $secure_layer_transport = true;
            if (strpos($parsed_address['host'], ':') === FALSE) {
                $parsed_address['host'] .= ":443";
            }
        }
        $this->connection = new AsyncTcpConnection($parsed_address['scheme'] . '://' . $parsed_address['host'] . $parsed_address['path']);
        if ($secure_layer_transport) $this->connection->transport = 'ssl';
        $this->connection->onMessage = [$this, 'onMessage'];
        $this->connection->onClose = [$this, 'onClose'];
        $this->connection->onError = [$this, 'onError'];
        $this->packets = new PacketRegistry([
            HelloPacket::class,
            HeartbeatPacket::class,
            IdentifyPacket::class,
            DispatchPacket::class,
            HeartbeatPacket::class,
            ResumePacket::class,
            HeartbeatAcknowledgePacket::class
        ]);
        $this->event_dispatcher = new EventDispatcher();
    }

    /**
     * 连接服务器
     */
    public function connect()
    {
        $this->connection->connect();
    }

    /**
     * 重新连接服务器
     */
    public function reconnect()
    {
        $this->connection->reconnect();
    }

    /**
     * 接收数据包并解码
     * @param AsyncTcpConnection $connection TCP连接
     * @param string $received_packet_raw 收到的原始数据包
     */
    public function onMessage(AsyncTcpConnection $connection, $received_packet_raw)
    {
        //echo '<- ' . $received_packet_raw . PHP_EOL;
        $packet_decoded = json_decode($received_packet_raw, true);
        if ($packet_decoded == null) return;
        $base_packet = BasePacket::fromRaw($packet_decoded);
        $this->event_dispatcher->dispatch($base_packet, 'on_packet');
        $packet = $this->packets->resolve($this->client, $base_packet);
        if ($packet == null) {
            return;
        }
        //if ($this->onPacketReceived != null) call_user_func($this->onPacketReceived, $this, $packet, $base_packet);
        // @Deprecated Use Event Model instead.
        $this->event_dispatcher->dispatch($packet, $packet::getPacketInformation()['name']);
    }

    /**
     * 发送数据包
     * @param Packet $packet 数据包
     */
    public function send(Packet $packet)
    {
        $packetRaw = json_encode($packet->pack()->toRaw());
        //echo '-> ' . $packetRaw . PHP_EOL;
        $this->connection->send($packetRaw);
    }

    public function onClose()
    {
        $this->event_dispatcher->dispatch($this, 'close');
    }

    public function onError()
    {
        $this->event_dispatcher->dispatch($this, 'error');
    }
}