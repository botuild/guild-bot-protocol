<?php


namespace Botuild\GuildBotProtocol\Util;


trait GetterMapper
{
    public function __get($key)
    {
        $method_name = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        if (method_exists($this, $method_name)) {
            $this->$method_name();
        }
    }

}