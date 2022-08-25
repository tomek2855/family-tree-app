<?php

namespace App\Services\FamilyTree;

use App\Contracts\FamilyTree\YoungestDescendantCache;
use App\Contracts\FamilyTree\YoungestDescendant;
use App\Models\Person;
use Illuminate\Support\Collection;

class FamilyTreeService implements YoungestDescendant
{
    public function __construct(
        private readonly YoungestDescendantCache $cache
    ) {}

    public function getYoungestDescendant(Person $person): Person|null
    {
        if ($this->cache->exists($person)) {
            return $this->cache->get($person);
        }

        $target = $this->findYoungestDescendant($person);

        $this->cache->add($person, $target);

        return $target;
    }

    private function findYoungestDescendant(Person $person): Person|null
    {
        $collection = collect([]);

        foreach ($person->children() as $child) {
            $this->extractDescendants($child, $collection);
        }

        return $collection->sortByDesc(fn (Person $person) => $person->birth_date)->first();
    }

    /**
     * @param Collection<Person> $collection
     */
    private function extractDescendants(Person $person, Collection &$collection): void
    {
        $collection->add($person);

        foreach ($person->children() as $child) {
            $this->extractDescendants($child, $collection);
        }
    }
}
