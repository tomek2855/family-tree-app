<?php

namespace App\Models;

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
        )->where('person_type', 'partner');
    }

    public function children(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, PeopleRelationship::class,
            firstKey: 'relation_id',
            secondKey: 'id',
            secondLocalKey: 'person_id',
        )->where('person_type', 'child');
    }
}
