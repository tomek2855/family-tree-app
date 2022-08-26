<?php

namespace App\Http\Requests\FamilyTree;

use App\Enums\PersonGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateFamilyTreeRequest extends FormRequest
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
        return [
            'family_tree_name' => 'required|string',
            'person_first_name' => 'required|string',
            'person_last_name' => 'nullable|string',
            'person_gender' => [
                'required',
                new Enum(PersonGender::class),
            ],
            'person_birth_date' => 'nullable|date',
            'person_death_date' => 'nullable|date',
        ];
    }
}
