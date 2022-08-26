<?php

namespace App\Http\Controllers;

use App\Enums\PersonGender;
use App\Extensions\Forms\DateInput;
use App\Extensions\Forms\Form;
use App\Extensions\Forms\SelectInput;
use App\Extensions\Forms\TextInput;
use App\Http\Requests\FamilyTree\CreateFamilyTreeRequest;
use App\Models\Tree;
use App\Services\FamilyTree\FamilyTreeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FamilyTreeController extends Controller
{
    public function getAll(): View
    {
        $trees = Tree::all();

        return view('family_tree.index', compact(
            'trees',
        ));
    }

    public function getOne(Tree $tree): View
    {
        return view('family_tree.view', compact(
            'tree',
        ));
    }

    public function getAdd(Request $request): View
    {
        $form = new Form(route('create-family-tree'));

        $form->addInput(
            (new TextInput('family_tree_name'))
                ->setPlaceholder('Family Tree Name')
                ->setRequired(true)
                ->setValue($request->old('family_tree_name'))
        );

        $form->addInput(
            (new TextInput('person_first_name'))
                ->setPlaceholder('Person First Name')
                ->setRequired(true)
                ->setValue($request->old('person_first_name'))
        );

        $form->addInput(
            (new TextInput('person_last_name'))
                ->setPlaceholder('Person Last Name')
                ->setValue($request->old('person_last_name'))
        );

        $form->addInput(
            (new SelectInput('person_gender', [
                PersonGender::female->name => 'Female',
                PersonGender::male->name => 'Male',
            ]))
                ->setPlaceholder('Person Gender')
                ->setRequired(true)
                ->setValue($request->old('person_gender'))
        );

        $form->addInput(
            (new DateInput('person_birth_date'))
                ->setPlaceholder('Person Birth Date')
                ->setValue($request->old('person_birth_date'))
        );

        $form->addInput(
            (new DateInput('person_death_date'))
                ->setPlaceholder('Person Death Date')
                ->setValue($request->old('person_death_date'))
        );

        return view('family_tree.add', compact(
            'form',
        ));
    }

    public function postAdd(CreateFamilyTreeRequest $request, FamilyTreeService $service)
    {
        $tree = $service->storeNewFamilyTreeWithPerson($request);

        if ($tree) {
            return redirect()->route('family-tree', [
                'tree' => $tree,
            ]);
        }

        return redirect()->route('add-family-tree');
    }
}
