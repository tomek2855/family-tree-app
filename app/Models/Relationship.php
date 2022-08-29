<?php

namespace App\Models;

use App\Enums\PersonRelationshipType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Relationship extends Model
{
    use HasFactory;

    public function partners(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, PeopleRelationship::class,
            firstKey: 'relation_id',
            secondKey: 'id',
            secondLocalKey: 'person_id',
        )->where('person_type', PersonRelationshipType::partner->name);
    }

    public function children(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, PeopleRelationship::class,
            firstKey: 'relation_id',
            secondKey: 'id',
            secondLocalKey: 'person_id',
        )->where('person_type', PersonRelationshipType::child->name);
    }
}
