<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = auth()->user()->availabilities;
        return view('availability.index', compact('availabilities'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        auth()->user()->availabilities()->create($validated);

        return back()->with('success', 'Availability added.');
    }

    public function destroy(\App\Models\Availability $availability)
    {
        if ($availability->user_id !== auth()->id()) {
            abort(403);
        }
        $availability->delete();
        return back()->with('success', 'Availability removed.');
    }
}
