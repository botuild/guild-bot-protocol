<?php


namespace Botuild\GuildBotProtocol\Structure\Enum;


use MyCLabs\Enum\Enum;

class AudioStatus extends Enum
{
    const START = 0;
    const PAUSE = 1;
    const RESUME = 2;
    const STOP = 3;
}