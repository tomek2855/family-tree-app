<?php

namespace App\Contracts\FamilyTree;

use App\Models\Person;

interface YoungestDescendantCache
{
    public function get(Person $person): Person|null;
    public function add(Person $person, ?Person $target): void;
    public function exists(Person $person): bool;
    public function flushAll(): void;
}
