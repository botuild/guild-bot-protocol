<?php

use Botuild\GuildBotProtocol\Credential\BotTokenCredential;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Client\WebsocketClient;
use Botuild\GuildBotProtocol\Networking\Intents;
use Botuild\GuildBotProtocol\Networking\Packets\DispatchPacket;
use Botuild\GuildBotProtocol\Networking\Packets\HelloPacket;
use Botuild\GuildBotProtocol\Networking\Packets\IdentifyPacket;

require 'vendor/autoload.php';
$worker = new Workerman\Worker();
$worker->onWorkerStart = function () {
    $botInformation = json_decode(file_get_contents('./.bot-test.json'), true);
    $credential = new BotTokenCredential($botInformation['id'], $botInformation['token']);
    $client = new ApiClient($credential);
    DispatchPacket::init();
    $client = new WebsocketClient($client);
    $client->onPacketRecieved = function ($connection, $packet) use ($credential) {

        if ($packet instanceof HelloPacket) {
            $identify = new IdentifyPacket(
                $credential->getAuthorizationPayload(),
                (new \Sokil\Bitmap())->setBits(
                    [Intents::AT_MESSAGE]
                )
            );
            $connection->send($identify);
        }
    };
    $client->connect();
};
Workerman\Worker::runAll();
