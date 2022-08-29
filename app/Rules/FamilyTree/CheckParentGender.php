<?php

namespace App\Rules\FamilyTree;

use App\Enums\PersonGender;
use App\Models\Person;
use Illuminate\Contracts\Validation\Rule;

class CheckParentGender implements Rule
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
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $parentPartnerGender = PersonGender::tryFrom($value);

        $parents = $this->person->getParents() ?? [];

        foreach ($parents as $parent) {
            if ($parent->gender === $parentPartnerGender) {
                return false;
            }
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
