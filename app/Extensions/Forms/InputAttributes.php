<?php

namespace App\Extensions\Forms;

interface InputAttributes
{
    public function setValue(mixed $value): self;
    public function setPlaceholder(mixed $value): self;
    public function setRequired(bool $value): self;
}
