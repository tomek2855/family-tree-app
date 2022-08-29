<?php

namespace App\Rules\FamilyTree;

use App\Enums\PersonGender;
use App\Models\Person;
use Illuminate\Contracts\Validation\Rule;

class CheckPartnerGender implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private Person $person,
    ) { }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        $partnerGender = PersonGender::tryFrom($value);

        if (!$partnerGender) {
            return false;
        }

        if ($this->person->gender === $partnerGender) {
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
        return 'Gender must be different than partner.';
    }
}
