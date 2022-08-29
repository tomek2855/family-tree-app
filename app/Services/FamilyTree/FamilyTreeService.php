<?php

namespace App\Services\FamilyTree;

use App\Contracts\FamilyTree\YoungestDescendantCache;
use App\Contracts\FamilyTree\YoungestDescendant;
use App\Enums\PersonRelationshipType;
use App\Http\Requests\FamilyTree\AddPersonToRelationship;
use App\Http\Requests\FamilyTree\CreateFamilyTreeRequest;
use App\Models\PeopleRelationship;
use App\Models\Person;
use App\Models\Relationship;
use App\Models\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FamilyTreeService implements YoungestDescendant
{
    public function __construct(
        private readonly YoungestDescendantCache $cache
    )
    {
    }

    public function getYoungestDescendant(Person $person): Person|null
    {
        if ($this->cache->exists($person)) {
            return $this->cache->get($person);
        }

        $target = $this->findYoungestDescendant($person);

        $this->cache->add($person, $target);

        return $target;
    }

    public function storeNewFamilyTreeWithPerson(CreateFamilyTreeRequest $request): ?Tree
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

            $relationship = $person->partnerRelationship()->firstOrCreate();

            $this->createPeopleRelationship($person, $relationship, PersonRelationshipType::partner->name);

            return $tree;
        });

        return $tree;
    }

    public function storePersonPartner(Person $person, AddPersonToRelationship $request): Person
    {
        $newPerson = DB::transaction(function () use ($person, $request) {
            $newPerson = $this->createPerson($request, $person->tree);

            $relationship = $person->partnerRelationship;

            $this->createPeopleRelationship($newPerson, $relationship, PersonRelationshipType::partner->name);

            return $newPerson;
        });

        return $newPerson;
    }

    public function storePersonChild(Person $person, AddPersonToRelationship $request): Person
    {
        $newPerson = DB::transaction(function () use ($person, $request) {
            $newPerson = $this->createPerson($request, $person->tree);

            $relationship = $person->partnerRelationship;

            $this->createPeopleRelationship($newPerson, $relationship, PersonRelationshipType::child->name);

            $partnerRelationship = Relationship::create();

            $this->createPeopleRelationship($newPerson, $partnerRelationship, PersonRelationshipType::partner->name);

            return $newPerson;
        });

        $this->cache->flushAll();

        return $newPerson;
    }

    public function storePersonParent(Person $person, AddPersonToRelationship $request): Person
    {
        $newPerson = DB::transaction(function () use ($person, $request) {
            $newPerson = $this->createPerson($request, $person->tree);

            $relationship = $person->parentsRelationship;

            if (!$relationship) {
                $relationship = Relationship::create();

                $this->createPeopleRelationship($newPerson, $relationship, PersonRelationshipType::partner->name);
                $this->createPeopleRelationship($person, $relationship, PersonRelationshipType::child->name);
            } else {
                $this->createPeopleRelationship($newPerson, $relationship, PersonRelationshipType::partner->name);
            }

            return $newPerson;
        });

        return $newPerson;
    }

    private function createPerson(Request $request, Tree $tree): Person
    {
        return Person::create($request->only([
                'first_name',
                'last_name',
                'gender',
                'birth_date',
                'death_date',
            ]) + ['tree_id' => $tree->id]);
    }

    private function createPeopleRelationship(Person $person, Relationship $relationship, string $type): PeopleRelationship
    {
        return PeopleRelationship::create([
            'person_id' => $person->id,
            'relation_id' => $relationship->id,
            'person_type' => $type,
        ]);
    }

    private function findYoungestDescendant(Person $person): Person|null
    {
        $collection = collect([]);

        foreach ($person->children() as $child) {
            $this->extractDescendants($child, $collection);
        }

        return $collection->sortByDesc(fn(Person $person) => $person->birth_date)->first();
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
