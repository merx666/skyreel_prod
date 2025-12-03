<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        // Get all operators with profiles that have geolocation data
        $operators = \App\Models\User::where('role', 'operator')
            ->whereHas('profile', function ($query) {
                $query->whereNotNull('latitude')
                      ->whereNotNull('longitude');
            })
            ->with('profile')
            ->get();

        return view('map.index', compact('operators'));
    }
}
