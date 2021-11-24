<?php
require 'vendor/autoload.php';
$worker = new Workerman\Worker();
$worker->onWorkerStart = function () {
    \Botuild\GuildBotProtocol\Networking\Packets\DispatchPacket::init();
    $client = new \Botuild\GuildBotProtocol\Networking\Client\WebsocketClient('wss://api.sgroup.qq.com/websocket/');
    $client->onPacketRecieved = function ($connection, $packet) {

        if ($packet instanceof \Botuild\GuildBotProtocol\Networking\Packets\HelloPacket) {
            $identify = new \Botuild\GuildBotProtocol\Networking\Packets\IdentifyPacket(
                file_get_contents('./.test-token'),
                (new \Sokil\Bitmap())->setBits(
                    [\Botuild\GuildBotProtocol\Networking\Intents::AT_MESSAGE]
                )
            );
            $connection->send($identify);
        }
    };
    $client->connect();
};
Workerman\Worker::runAll();