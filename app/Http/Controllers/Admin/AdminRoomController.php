<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = \App\Models\Room::paginate(15);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string|unique:rooms,number',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['features'] = $data['features'] ? array_values(array_filter(array_map('trim', explode(',', $data['features'])))) : null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
            $data['image'] = $imagePath;
        }

        \App\Models\Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = \App\Models\Room::findOrFail($id);
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = \App\Models\Room::findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = \App\Models\Room::findOrFail($id);

        $data = $request->validate([
            'number' => 'required|string|unique:rooms,number,'.$room->id,
            'type' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['features'] = $data['features'] ? array_values(array_filter(array_map('trim', explode(',', $data['features'])))) : null;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            $imagePath = $request->file('image')->store('rooms', 'public');
            $data['image'] = $imagePath;
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = \App\Models\Room::findOrFail($id);
        
        // Delete image if exists
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }
        
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
