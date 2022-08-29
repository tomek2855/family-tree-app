<?php

namespace App\Enums;

enum PersonRelationshipType: string
{
    case partner = 'partner';
    case child = 'child';
    case parent = 'parent';
}
