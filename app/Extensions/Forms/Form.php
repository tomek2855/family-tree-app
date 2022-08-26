<?php

namespace App\Extensions\Forms;

use Illuminate\View\View;

class Form
{
    /**
     * @var InputBase[]
     */
    private array $inputs = [];

    public function __construct(
        public ?string $url = null,
    ) {}

    public function addInput(InputBase $input): void
    {
        $this->inputs[] = $input;
    }

    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function generate(): View
    {
        return view('extensions.forms.base', [
            'form' => $this,
        ]);
    }
}
