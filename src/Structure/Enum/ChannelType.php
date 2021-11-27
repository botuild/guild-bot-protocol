<?php


namespace Botuild\GuildBotProtocol\Structure\Enum;


class ChannelType extends \MyCLabs\Enum\Enum
{
    const TEXT = 0;
    const AUDIO = 2;
    const GROUP = 4;
    const LIVE = 10005;
    const MINI_APP = 10006;
    const DISCUSSION = 10007;
}