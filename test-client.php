<?php

use Botuild\GuildBotProtocol\Networking\Client\ApiClient;

require 'vendor/autoload.php';
/*$worker = new Workerman\Worker();
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
Workerman\Worker::runAll();*/
$botInformation = json_decode(file_get_contents('./.bot-test.json'), true);
//id token
$credential = new \Botuild\GuildBotProtocol\Credential\BotTokenCredential($botInformation['id'], $botInformation['token']);
$client = new ApiClient($credential);
var_dump($client->get('/gateway'));