<?php

namespace App\Http\Controllers;

use App\Contracts\FamilyTree\YoungestDescendant;
use App\Models\Person;
use Illuminate\Contracts\View\View;

class PeopleController extends Controller
{
    public function getOne(Person $person, YoungestDescendant $youngestDescendant): View
    {
        $youngestPerson = $youngestDescendant->getYoungestDescendant($person);

        return view('people.index', compact(
            'person',
            'youngestPerson',
        ));
    }
}
