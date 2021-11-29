<?php


namespace Botuild\GuildBotProtocol\Networking\Client;


use Botuild\GuildBotProtocol\Credential\Credential;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ApiClient
{
    protected Credential $credential;
    public Client $client;

    /**
     * 初始化类
     * @param Credential $credential 凭据信息
     * @param string $base_uri 腾讯机器人API服务器(默认为生产环境)
     * @return void
     */
    public function __construct(Credential $credential, $base_uri = 'https://api.sgroup.qq.com/')
    {
        $this->credential = $credential;
        $this->client = new Client([
            'base_uri' => $base_uri
        ]);
    }

    /**
     * @param Request $request HTTP请求
     * @return array 返回的HTTP已解码数据
     * @throws \GuzzleHttp\Exception\GuzzleException HTTP请求异常
     */
    public function send(Request $request)
    {
        return json_decode($this->client->send($request)->getBody()->getContents(), true);
    }

    /**
     * 组装当前请求的请求头
     * @return array
     */
    public function getRequestHeader(): array
    {
        return [
            'Authorization' => $this->credential->getAuthorizationPayload(),
            'User-Agent' => 'Botuild/0.1 (Guzzle Client)',
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * @param string $url 相对于服务器根目录的相对URL
     * @return array 返回的HTTP已解码数据
     * @throws \GuzzleHttp\Exception\GuzzleException HTTP请求异常
     */
    public function get($url)
    {
        return $this->send(new Request('GET', $url, $this->getRequestHeader()));
    }

    /**
     * @param string $url 相对于服务器根目录的相对URL
     * @param string $payload 已JSON编码的负载数据
     * @return array 返回的HTTP已解码数据
     * @throws \GuzzleHttp\Exception\GuzzleException HTTP请求异常
     */
    public function post($url, $payload)
    {
        return $this->send(new Request('POST', $url, $this->getRequestHeader(), $payload));
    }

}