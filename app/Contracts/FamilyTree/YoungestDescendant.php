<?php

namespace App\Contracts\FamilyTree;

use App\Models\Person;

interface YoungestDescendant
{
    public function getYoungestDescendant(Person $person): Person|null;
}
