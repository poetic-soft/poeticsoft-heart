<?php

namespace Poeticsoft\Heart\Template;

abstract class AIAgent
{
    abstract public function chat($params);
    abstract public function createImage($prompt);
}
