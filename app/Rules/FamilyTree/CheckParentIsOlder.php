<?php

namespace App\Rules\FamilyTree;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckParentIsOlder implements Rule
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
        $personParents = $this->person->getParents();
        $personParentsChildren = $personParents->first() ? $personParents->first()->children() : null;

        if (!$personParentsChildren) {
            return true;
        }

        $date = Carbon::make($value);

        $result = true;

        $personParentsChildren->each(function (Person $child) use ($date, &$result) {
            if ($child->birth_date && $date->greaterThanOrEqualTo($child->birth_date)) {
                $result = false;
            }
        });

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Parent must be younger than children.';
    }
}
