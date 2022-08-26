<?php

namespace App\Extensions\Forms;

class TextInput extends InputBase
{
    const VIEW_PATH = 'input-text';

    public function __construct(string $name)
    {
        parent::__construct($name, 'text');
    }

    public function getViewPath(): string
    {
        return self::VIEW_PATH;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setPlaceholder(mixed $value): self
    {
        $this->attributes['placeholder'] = $value;

        return $this;
    }

    public function setRequired(bool $value): self
    {
        $this->attributes['required'] = $value;

        return $this;
    }
}
