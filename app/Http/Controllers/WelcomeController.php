<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $properties = Property::available()
            ->with('featuredPhoto')
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('properties'));
    }
}
