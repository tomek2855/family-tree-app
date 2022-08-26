<?php

namespace App\Extensions\Forms;

class SelectInput extends InputBase
{
    const VIEW_PATH = 'input-select';

    private array $options;

    /**
     * @param array<string, string> $options
     */
    public function __construct(string $name, array $options = [])
    {
        parent::__construct($name, 'select');
        $this->options = $options;
    }

    public function getViewPath(): string
    {
        return self::VIEW_PATH;
    }

    public function getOptions(): array
    {
        return $this->options;
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
