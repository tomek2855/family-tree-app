<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tree extends Model
{
    use HasFactory;

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
