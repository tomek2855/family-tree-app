<?php

namespace App\Enums;

enum AddPersonToRelationshipType: string
{
    case partner = 'partner';
    case child = 'child';
    case parent = 'parent';
}
