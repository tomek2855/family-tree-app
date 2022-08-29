<?php

namespace App\Http\Controllers;

use App\Contracts\FamilyTree\YoungestDescendant;
use App\Enums\AddPersonToRelationshipType;
use App\Enums\PersonGender;
use App\Extensions\Forms\DateInput;
use App\Extensions\Forms\Form;
use App\Extensions\Forms\SelectInput;
use App\Extensions\Forms\TextInput;
use App\Http\Requests\FamilyTree\AddPersonToRelationship;
use App\Models\Person;
use App\Services\FamilyTree\FamilyTreeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function getOne(Person $person, YoungestDescendant $youngestDescendant): View
    {
        $youngestPerson = $youngestDescendant->getYoungestDescendant($person);
        $partner = $person->getPartner();

        return view('people.index', compact(
            'person',
            'youngestPerson',
            'partner',
        ));
    }

    public function getAdd(Person $person, string $type, Request $request): View
    {
        $type = AddPersonToRelationshipType::from($type);

        $form = new Form(route('create-person', compact('person', 'type')));

        $form->addInput(
            (new TextInput('first_name'))
                ->setPlaceholder('First Name')
                ->setRequired(true)
                ->setValue($request->old('first_name'))
        );

        $form->addInput(
            (new TextInput('last_name'))
                ->setPlaceholder('Last Name')
                ->setValue($request->old('last_name'))
        );

        $form->addInput(
            (new SelectInput('gender', [
                PersonGender::female->name => 'Female',
                PersonGender::male->name => 'Male',
            ]))
                ->setPlaceholder('Gender')
                ->setRequired(true)
                ->setValue($request->old('gender'))
        );

        $form->addInput(
            (new DateInput('birth_date'))
                ->setPlaceholder('Birth Date')
                ->setValue($request->old('birth_date'))
        );

        $form->addInput(
            (new DateInput('death_date'))
                ->setPlaceholder('Death Date')
                ->setValue($request->old('death_date'))
        );

        return view('people.add', compact(
            'form',
            'type',
            'person',
        ));
    }

    public function postAdd(Person $person, string $type, AddPersonToRelationship $request, FamilyTreeService $service): RedirectResponse
    {
        $type = AddPersonToRelationshipType::from($type);

        $newPerson = match ($type) {
            AddPersonToRelationshipType::partner => $service->storePersonPartner($person, $request),
            AddPersonToRelationshipType::child => $service->storePersonChild($person, $request),
            AddPersonToRelationshipType::parent => $service->storePersonParent($person, $request),
        };

        return redirect()->route('person', [
            'person' => $newPerson,
        ]);
    }
}
