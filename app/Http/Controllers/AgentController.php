<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    // Display agent's properties
    public function index()
    {
        abort_unless(Auth::user()->hasRole('agent'), 403);

        $properties = Property::with('images')
            ->where('user_id', Auth::id())
            ->where('owner_type', 'agent')
            ->latest()
            ->get();

        return view('agent.property.index', compact('properties'));
    }

    // Show create property form
    public function create()
    {
        abort_unless(Auth::user()->hasRole('agent'), 403);

        return view('agent.property.create');
    }

    // Store new property
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check role and set owner type automatically
        if ($user->hasRole('agent')) {
            $ownerType = 'agent';
        } else {
            abort(403, 'Unauthorized action.');
        }

        // Validate property data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'property_type' => 'required|string',
            'purpose' => 'required|string',
            'price' => 'required|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'area_unit' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'kitchens' => 'nullable|integer|min:0',
            'location' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|string',
            'featured' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Create property in properties table
        $property = Property::create([
            'user_id' => $user->id,
            'owner_type' => $ownerType,

            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'property_type' => $validated['property_type'],
            'purpose' => $validated['purpose'],
            'price' => $validated['price'],
            'area' => $validated['area'] ?? null,
            'area_unit' => $validated['area_unit'] ?? null,
            'bedrooms' => $validated['bedrooms'] ?? null,
            'bathrooms' => $validated['bathrooms'] ?? null,
            'kitchens' => $validated['kitchens'] ?? null,
            'location' => $validated['location'] ?? null,
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'status' => $validated['status'],
            'featured' => $validated['featured'] ?? 0,
        ]);

        // Upload property images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image' => $path,
                ]);
            }
        }
       

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Property added successfully!');
    }

    // Show edit form
    public function edit(string $id)
    {
        abort_unless(Auth::user()->hasRole('agent'), 403);

        $property = Property::where('user_id', Auth::id())
            ->where('owner_type', 'agent')
            ->with('images')
            ->findOrFail($id);

        return view('agent.property.edit', compact('property'));
    }

    // Update property
    public function update(Request $request, string $id)
    {
        abort_unless(Auth::user()->hasRole('agent'), 403);

        // Agent can update only their own property
        $property = Property::where('user_id', Auth::id())
            ->where('owner_type', 'agent')
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'property_type' => 'required|string',
            'purpose' => 'required|string',
            'price' => 'required|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'area_unit' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'kitchens' => 'nullable|integer|min:0',
            'location' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|string',
            'featured' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Update property details
        $property->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'property_type' => $validated['property_type'],
            'purpose' => $validated['purpose'],
            'price' => $validated['price'],
            'area' => $validated['area'] ?? null,
            'area_unit' => $validated['area_unit'] ?? null,
            'bedrooms' => $validated['bedrooms'] ?? null,
            'bathrooms' => $validated['bathrooms'] ?? null,
            'kitchens' => $validated['kitchens'] ?? null,
            'location' => $validated['location'] ?? null,
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'status' => $validated['status'],
            'featured' => $request->boolean('featured'),
        ]);

        // Replace images only when new images are uploaded
        if ($request->hasFile('images')) {

            foreach ($property->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image);
                $oldImage->delete();
            }

            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Property updated successfully!');
    }

    // Delete property
    public function destroy(string $id)
    {
        abort_unless(Auth::user()->hasRole('agent'), 403);

        // Agent can delete only their own property
        $property = Property::where('user_id', Auth::id())
            ->where('owner_type', 'agent')
            ->with('images')
            ->findOrFail($id);

        // Delete associated image files and database records
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $property->delete();

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Property deleted successfully!');
    }
}
