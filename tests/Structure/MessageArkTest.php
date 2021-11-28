<?php

namespace Networking;

use Botuild\GuildBotProtocol\Structure\MessageArk;
use PHPUnit\Framework\TestCase;

class MessageArkTest extends TestCase
{

    public function testPack()
    {
        $this->assertTrue(true);//@TODO:Pack test
    }

    public function testParse()
    {
        $json = <<<JSON
{
    "ark": {
        "template_id": 1,
        "kv": [
            {
                "key": "#DESC#",
                "value": "机器人订阅消息"
            },
            {
                "key": "#PROMPT#",
                "value": "XX机器人"
            },
            {
                "key": "#TITLE#",
                "value": "XX机器人消息"
            },
            {
                "key": "#META_URL#",
                "value": "http://domain.com/"
            },
            {
                "key": "#META_LIST#",
                "obj": [
                    {
                        "obj_kv": [
                            {
                                "key": "name",
                                "value": "aaa"
                            },
                            {
                                "key": "age",
                                "value": "3"
                            }
                        ]
                    },
                    {
                        "obj_kv": [
                            {
                                "key": "name",
                                "value": "bbb"
                            },
                            {
                                "key": "age",
                                "value": "4"
                            }
                        ]
                    }
                ]
            }
        ]
    }
}
JSON;
        $json = json_decode($json, true)['ark'];
        $ark = MessageArk::parse($json);
        $this->assertEquals($ark->map['#DESC#']->value, '机器人订阅消息');
        $this->assertEquals($ark->template_id, 1);
        $this->assertEquals($ark->map['#META_LIST#']->objects[0]->object_map['name'], 'aaa');
    }
}
