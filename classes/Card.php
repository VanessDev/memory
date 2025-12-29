<?php

class Card
{
    public string $id;
    public int $value;
    public bool $isFound = false;

    public function __construct(string $id, int $value)
    {
        $this->id    = $id;
        $this->value = $value;
    }
}
