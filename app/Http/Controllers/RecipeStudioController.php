<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class RecipeStudioController extends Controller
{
    public function __invoke(): View
    {
        return view('recipes.studio');
    }
}
