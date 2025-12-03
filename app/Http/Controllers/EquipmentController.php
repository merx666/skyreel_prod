<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Equipment::class);
        
        $equipment = Auth::user()->equipment()->paginate(10);
        
        return view('equipment.index', compact('equipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Equipment::class);
        
        return view('equipment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Equipment::class);
        
        $validated = $request->validate([
            'type' => 'required|in:drone,camera,lens,accessory',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('equipment', 'public');
            $validated['image_url'] = $path;
        }

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Sprzęt został dodany pomyślnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $this->authorize('view', $equipment);
        
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $this->authorize('update', $equipment);
        
        return view('equipment.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $this->authorize('update', $equipment);
        
        $validated = $request->validate([
            'type' => 'required|in:drone,camera,lens,accessory',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($equipment->image_url) {
                Storage::disk('public')->delete($equipment->image_url);
            }
            
            $path = $request->file('image')->store('equipment', 'public');
            $validated['image_url'] = $path;
        }

        $equipment->update($validated);

        return redirect()->route('equipment.index')
            ->with('success', 'Sprzęt został zaktualizowany pomyślnie.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $this->authorize('delete', $equipment);
        
        // Delete image if exists
        if ($equipment->image_url) {
            Storage::disk('public')->delete($equipment->image_url);
        }
        
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Sprzęt został usunięty pomyślnie.');
    }
}
