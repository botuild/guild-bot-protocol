<?php


namespace Botuild\GuildBotProtocol\Types;


class CountLimiter
{
    public $current = 0;
    public $total = 0;

    public function __construct($current, $total)
    {
        $this->current = $current;
        $this->total = $total;
    }

    public function isValid()
    {
        return $this->current < $this->total && $this->current > 0;
    }

    public function isValidAfter(int $change)
    {
        return ($this->current + $change) < $this->total && ($this->current + $change) > 0;
    }
}