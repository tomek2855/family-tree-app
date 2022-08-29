<?php

namespace App\Rules\FamilyTree;

use App\Models\Person;
use Illuminate\Contracts\Validation\Rule;

class CheckPartnerNotExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private Person $person
    ) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        if ($this->person->getPartner()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This person has already a partner.';
    }
}
