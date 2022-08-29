<?php

namespace App\Rules\FamilyTree;

use App\Models\Person;
use Illuminate\Contracts\Validation\Rule;

class CheckParentsCount implements Rule
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
        $parents = $this->person->getParents();

        if (!$parents) {
            return true;
        }

        return count($parents) < 2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Child can have max two parents.';
    }
}
