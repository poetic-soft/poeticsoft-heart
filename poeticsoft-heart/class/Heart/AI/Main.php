<?php

namespace Poeticsoft\Heart\AI;

use Poeticsoft\Heart\AI\PromptBuilder;

class Main
{
    protected static $eventDispatcher;

    public static function prompt($message): PromptBuilder
    {

        return new PromptBuilder($message);
    }

    public static function setEventDispatcher($dispatcher)
    {

        self::$eventDispatcher = $dispatcher;
    }

    public static function getEventDispatcher()
    {

        return self::$eventDispatcher;
    }
}
