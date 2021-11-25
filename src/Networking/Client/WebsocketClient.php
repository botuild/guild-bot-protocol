<?php


namespace Botuild\GuildBotProtocol\Networking\Client;


use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Packet;
use Botuild\GuildBotProtocol\Networking\Packets\DispatchPacket;
use Botuild\GuildBotProtocol\Networking\Packets\HeartbeatPacket;
use Botuild\GuildBotProtocol\Networking\Packets\HelloPacket;
use Botuild\GuildBotProtocol\Networking\Packets\IdentifyPacket;
use Botuild\GuildBotProtocol\Registry\PacketRegistry;
use Workerman\Connection\AsyncTcpConnection;

class WebsocketClient
{
    public AsyncTcpConnection $connection;
    public PacketRegistry $packets;
    public $onPacketRecieved = null;
    public ApiClient $client;

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
            DispatchPacket::class
        ]);
    }

    public function connect()
    {
        $this->connection->connect();
    }

    public function reconnect()
    {
        $this->connection->reconnect();
    }

    public function onMessage(AsyncTcpConnection $connection, $received_packet_raw)
    {
        echo '<- ' . $received_packet_raw . PHP_EOL;
        $packet_decoded = json_decode($received_packet_raw, true);
        if ($packet_decoded == null) return;
        $base_packet = BasePacket::fromRaw($packet_decoded);
        $packet = $this->packets->resolve($base_packet, $this->client);
        if ($packet == null) {
            //Process unregistered packet
            return;
        }
        if ($this->onPacketRecieved != null) call_user_func($this->onPacketRecieved, $this, $packet);
    }

    public function send(Packet $packet)
    {
        $packetRaw = json_encode($packet->pack()->toRaw());
        echo '-> ' . $packetRaw . PHP_EOL;
        $this->connection->send($packetRaw);
    }

    public function onClose()
    {
        //@TODO:Forward the event to user
    }

    public function onError()
    {
        //@TODO:Forward the event to user
    }
}