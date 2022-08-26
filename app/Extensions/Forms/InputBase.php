<?php

namespace App\Extensions\Forms;

abstract class InputBase implements InputAttributes
{
    public function __construct(
        public string $name,
        public string $type,
        public ?string $value = null,
        public string $class = '',
        public string $style = '',
        public array $attributes = [],
    ) {}

    public function getAttribute(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    abstract public function getViewPath(): string;
}
