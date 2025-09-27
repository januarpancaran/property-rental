<?php

namespace App\Http\Controllers;

use Illuminate\App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display listing of all properties (public view)
     */
    public function index()
    {
        return response()->json(['message' => 'You can view available properties']);
    }

    /**
     * Display properties for admin (all properties)
     */
    public function adminIndex()
    {
        return response()->json(['message' => 'You can view all properties']);
    }

    /**
     * Create Property Form
     */
    public function create()
    {
        return response()->json(['message' => 'You can create a property']);
    }
}
