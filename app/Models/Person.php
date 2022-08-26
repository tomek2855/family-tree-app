<?php

namespace App\Models;

use App\Enums\PersonGender;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Collection;

class Person extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'people';

    protected $casts = [
        'gender' => PersonGender::class,
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    public function tree(): HasOne
    {
        return $this->hasOne(Tree::class);
    }

    public function partnerRelationship(): HasOneThrough
    {
        return $this->hasOneThrough(Relationship::class, PeopleRelationship::class,
            secondKey: 'id',
            secondLocalKey: 'relation_id',
        )
            ->where('person_type', 'partner');
    }

    /**
     * @return Collection<Person>
     */
    public function children(): Collection
    {
        $partnerRelationship = $this->partnerRelationship;

        if ($partnerRelationship) {
            return $partnerRelationship->children()->get();
        }

        return collect([]);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $firstName = $attributes['first_name'];
                $lastName = $attributes['last_name'];

                return sprintf('%s %s', $firstName, $lastName);
            },
        );
    }
}
