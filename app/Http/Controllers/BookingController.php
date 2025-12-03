<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookingsAsClient()->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'operator_id' => 'required|exists:users,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string',
        ]);

        // TODO: Advanced availability check against Availability model

        $booking = \App\Models\Booking::create([
            'client_id' => auth()->id(),
            'operator_id' => $validated['operator_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'pending',
            'notes' => $validated['notes'],
            'total_price' => 0, // Placeholder for calculation
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking request sent!');
    }
}
