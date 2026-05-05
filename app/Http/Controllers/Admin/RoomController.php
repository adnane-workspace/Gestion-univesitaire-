<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:rooms,code',
            'name' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'floor' => 'required|integer|min:0|max:20',
            'capacity' => 'required|integer|min:1|max:500',
            'type' => 'required|in:classroom,amphitheater,lab,conference',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Salle créée avec succès');
    }

    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:rooms,code,' . $room->id,
            'name' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'floor' => 'required|integer|min:0|max:20',
            'capacity' => 'required|integer|min:1|max:500',
            'type' => 'required|in:classroom,amphitheater,lab,conference',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Salle mise à jour avec succès');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Salle supprimée avec succès');
    }
}
