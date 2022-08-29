<?php

namespace App\Rules\FamilyTree;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckChildIsYounger implements Rule
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
        $partner = $this->person->getPartner();

        $date = Carbon::make($value);

        if ($this->person->birth_date && $date->lessThanOrEqualTo($this->person->birth_date)) {
            return false;
        }

        if ($partner && $partner->birth_date && $date->lessThanOrEqualTo($partner->birth_date)) {
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
        return 'Child must be younger than both parents.';
    }
}
