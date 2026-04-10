<?php

namespace Poeticsoft\Heart\AI;

class Main
{
    public $heart;

    protected $prompt;
    protected $model = null;
    protected $provider = null;
    protected $systemInstruction = '';
    protected $temperature = 0.7;
    protected $maxTokens = null;

    public function __construct($heart)
    {

        $this->heart = $heart;
    }

    public function prompt($prompt)
    {

        $this->prompt = $prompt;

        return $this;
    }

    public function usingModel($model): self
    {

        $this->model = $model;

        return $this;
    }

    public function usingProvider($provider): self
    {

        $this->provider = $provider;

        return $this;
    }

    public function usingSystemInstruction($instruction): self
    {

        $this->systemInstruction = $instruction;

        return $this;
    }

    public function usingTemperature(float $temp): self
    {

        $this->temperature = $temp;

        return $this;
    }

    public function usingMaxTokens(int $tokens): self
    {

        $this->maxTokens = $tokens;

        return $this;
    }
}
