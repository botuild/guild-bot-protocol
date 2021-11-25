<?php


namespace Botuild\GuildBotProtocol\Networking\Client;


use Botuild\GuildBotProtocol\Credential\Credential;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ApiClient
{
    protected Credential $credential;
    public Client $client;

    public function __construct(Credential $credential, $base_uri = 'https://api.sgroup.qq.com/')
    {
        $this->credential = $credential;
        $this->client = new Client([
            'base_uri' => $base_uri
        ]);
    }

    public function send(Request $request)
    {
        return json_decode($this->client->send($request)->getBody()->getContents(), true);
    }

    public function getRequestHeader()
    {
        return [
            'Authorization' => $this->credential->getAuthorizationPayload(),
            'User-Agent' => 'Botuild/0.1 (Guzzle Client)'
        ];
    }

    public function get($url)
    {
        return $this->send(new Request('GET', $url, $this->getRequestHeader()));
    }

    public function post($url, $payload)
    {
        return $this->send(new Request('POST', $url, $this->getRequestHeader(), $payload));
    }

}