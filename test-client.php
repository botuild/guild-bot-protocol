<?php

use Botuild\GuildBotProtocol\Credential\BotTokenCredential;
use Botuild\GuildBotProtocol\Networking\BasePacket;
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
    $client = new ApiClient($credential, 'https://sandbox.api.sgroup.qq.com');
    DispatchPacket::init();
    $ws_client = new WebsocketClient($client);
    /*$roles = \Botuild\GuildBotProtocol\Structure\Guild::get('2924999043509161390', $client)->getChannels();
    foreach ($roles as $role) {
        echo $role->name . ' ' . $role->type . PHP_EOL;
    }*/
    $ws_client->onPacketReceived = function ($connection, $packet) use ($credential, $client) {
        var_dump($packet);
        if ($packet instanceof HelloPacket) {
            $identify = new IdentifyPacket(
                $credential->getAuthorizationPayload(),
                (new \Sokil\Bitmap())->setBits(
                    [Intents::AT_MESSAGE]
                )
            );
            $connection->send($identify);
        }
        if ($packet instanceof \Botuild\GuildBotProtocol\Networking\Packets\Events\AtMessageEvent) {
            $botMsg = new \Botuild\GuildBotProtocol\Structure\BotMessage();
            $botMsg->setContent('你好，测试！')->attachMessage($packet->message)->withClient($client);
            var_dump($botMsg->pack());
            $botMsg->send();
        }
    };
    $ws_client->connect();
};
Workerman\Worker::runAll();
