<?php

namespace App\Services\FamilyTree;

use App\Contracts\FamilyTree\YoungestDescendantCache;
use App\Contracts\FamilyTree\YoungestDescendant;
use App\Http\Requests\FamilyTree\CreateFamilyTreeRequest;
use App\Models\Person;
use App\Models\Tree;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function storeNewFamilyTreeWithPerson(CreateFamilyTreeRequest $request): Tree
    {
        $tree = DB::transaction(function () use ($request) {
            $tree = new Tree([
                'name' => $request->get('family_tree_name'),
            ]);
            $tree->save();

            $person = new Person([
                'first_name' => $request->get('person_first_name'),
                'last_name' => $request->get('person_last_name'),
                'gender' => $request->get('person_gender'),
                'birth_date' => $request->get('person_birth_date'),
                'death_date' => $request->get('person_death_date'),
                'tree_id' => $tree->id,
            ]);
            $person->save();

            return $tree;
        });

        return $tree;
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
