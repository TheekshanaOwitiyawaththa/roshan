<?php

namespace App\Http\Controllers;

use App\Models\CoachingProgram;
use App\Models\LinkPost;
use App\Models\Location;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'coachingPrograms' => CoachingProgram::query()->active()->ordered()->get(),
            'locations' => Location::query()->active()->ordered()->get(),
            'linkPosts' => LinkPost::query()->active()->ordered()->get(),
        ]);
    }
}
