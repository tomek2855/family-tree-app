<?php

namespace App\Http\Requests\FamilyTree;

use App\Enums\PersonRelationshipType;
use App\Enums\PersonGender;
use App\Rules\FamilyTree\CheckChildIsYounger;
use App\Rules\FamilyTree\CheckParentGender;
use App\Rules\FamilyTree\CheckParentIsOlder;
use App\Rules\FamilyTree\CheckParentsCount;
use App\Rules\FamilyTree\CheckPartnerGender;
use App\Rules\FamilyTree\CheckPartnerNotExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AddPersonToRelationship extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        list($type, $person) = $this->getRouteData();

        $rules = [
            'first_name' => [
                'required',
                'string',
            ],
            'last_name' => 'nullable|string',
            'gender' => [
                'required',
                new Enum(PersonGender::class),
            ],
            'birth_date' => [
                'nullable',
                'date',
            ],
            'death_date' => 'nullable|date',
        ];

        switch ($type) {
            case PersonRelationshipType::partner:
                $rules['first_name'][] = new CheckPartnerNotExists($person);
                $rules['gender'][] = new CheckPartnerGender($person);
                break;
            case PersonRelationshipType::child:
                $rules['birth_date'][] = new CheckChildIsYounger($person);
                break;
            case PersonRelationshipType::parent:
                $rules['first_name'][] = new CheckParentsCount($person);
                $rules['gender'][] = new CheckParentGender($person);
                $rules['birth_date'][] = new CheckParentIsOlder($person);
                break;
        }

        return $rules;
    }

    private function getRouteData(): array
    {
        $typeString = $this->route('type');

        $type = PersonRelationshipType::from($typeString);

        $person = $this->route('person');

        return [$type, $person];
    }
}
