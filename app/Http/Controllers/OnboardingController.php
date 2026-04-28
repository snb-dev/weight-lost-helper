<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class OnboardingController extends Controller
{
    public function __invoke(): View
    {
        return view('onboarding');
    }
}
