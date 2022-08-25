<?php

namespace App\Http\Controllers;

use App\Models\Tree;
use Illuminate\Contracts\View\View;

class FamilyTreeController extends Controller
{
    public function getAll(): View
    {
        $trees = Tree::all();

        return view('family_tree.index', compact(
            'trees',
        ));
    }

    public function getOne(Tree $tree): View
    {
        return view('family_tree.view', compact(
            'tree',
        ));
    }
}
