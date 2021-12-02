<?php

use Botuild\GuildBotProtocol\Credential\BotTokenCredential;
use Botuild\GuildBotProtocol\Networking\BasePacket;
use Botuild\GuildBotProtocol\Networking\Client\ApiClient;
use Botuild\GuildBotProtocol\Networking\Client\WebsocketClient;
use Botuild\GuildBotProtocol\Networking\Intents;
use Botuild\GuildBotProtocol\Networking\Packet;
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
    $ws_client->event_dispatcher->addListener('hello', function (Packet $packet) use ($credential, $ws_client) {
        $identify = new IdentifyPacket(
            $credential->getAuthorizationPayload(),
            (new \Sokil\Bitmap())->setBits(
                [Intents::AT_MESSAGE]
            )
        );
        $ws_client->send($identify);
    });
    $ws_client->event_dispatcher->addListener('at_message', function (Packet $packet) use ($credential, $ws_client, $client) {
        $botMsg = new \Botuild\GuildBotProtocol\Structure\BotMessage();
        $botMsg->setContent('你好，测试！')->attachMessage($packet->message)->withClient($client);
        $botMsg->send();
    });
    $ws_client->connect();
};
Workerman\Worker::runAll();
