<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route("login");
        }

        if ($user->isAdmin())
            return redirect()->route("admin.users.index");
        if ($user->isLandlord())
            return redirect()->route("properties.my.index");
        if ($user->isTenant())
            return redirect()->route("properties.index");
    }
}
