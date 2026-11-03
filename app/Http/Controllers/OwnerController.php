<?php

namespace App\Http\Controllers;

use App\Models\BuyerInquiry;
use App\Models\OwnerProperty;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display Owner Properties
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $userId = Auth::id();
        $properties = Property::with('images')
            ->where('user_id', $userId)
            ->where('owner_type', 'owner')
            ->latest()
            ->get();

        if ($properties->isEmpty()) {
            $properties = OwnerProperty::with('images')
                ->where('user_id', $userId)
                ->latest()
                ->get();
        }

        return view('owner.property.index', compact('properties'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create Property Form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('owner.property.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Property
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check owner role
        if (!$user || !$user->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'property_type' => 'required|string',
            'purpose'       => 'required|string',
            'price'         => 'required|numeric|min:0',
            'area'          => 'nullable|numeric|min:0',
            'area_unit'     => 'nullable|string',
            'bedrooms'      => 'nullable|integer|min:0',
            'bathrooms'     => 'nullable|integer|min:0',
            'kitchens'      => 'nullable|integer|min:0',
            'location'      => 'nullable|string',
            'city'          => 'nullable|string',
            'address'       => 'nullable|string',
            'status'        => 'required|string',
            'featured'      => 'nullable|boolean',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Save property in common properties table
        $property = Property::create([
            'user_id'       => $user->id,
            'owner_type'    => 'owner',
            'title'         => $validated['title'],
            'description'   => $validated['description'] ?? null,
            'property_type' => $validated['property_type'],
            'purpose'       => $validated['purpose'],
            'price'         => $validated['price'],
            'area'          => $validated['area'] ?? null,
            'area_unit'     => $validated['area_unit'] ?? null,
            'bedrooms'      => $validated['bedrooms'] ?? null,
            'bathrooms'     => $validated['bathrooms'] ?? null,
            'kitchens'      => $validated['kitchens'] ?? null,
            'location'      => $validated['location'] ?? null,
            'city'          => $validated['city'] ?? null,
            'address'       => $validated['address'] ?? null,
            'status'        => $validated['status'],
            'featured'      => $validated['featured'] ?? 0,
        ]);

        // Save property images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image'       => $path,
                ]);
            }
        }

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Property added successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Show Property
    |--------------------------------------------------------------------------
    */
    public function show(string $id)
    {
        $property = Property::with('images')
            ->where('user_id', Auth::id())
            ->where('owner_type', 'owner')
            ->findOrFail($id);

        return view('owner.property.show', compact('property'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Property Form
    |--------------------------------------------------------------------------
    */
    public function edit(string $id)
    {
        $property = Property::with('images')
            ->where('user_id', Auth::id())
            ->where('owner_type', 'owner')
            ->findOrFail($id);

        return view('owner.property.edit', compact('property'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Property
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        // Owner can only update their own properties
        $property = Property::where('user_id', $user->id)
            ->where('owner_type', 'owner')
            ->findOrFail($id);

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'property_type' => 'required|string',
            'purpose'       => 'required|string',
            'price'         => 'required|numeric|min:0',
            'area'          => 'nullable|numeric|min:0',
            'area_unit'     => 'nullable|string',
            'bedrooms'      => 'nullable|integer|min:0',
            'bathrooms'     => 'nullable|integer|min:0',
            'kitchens'      => 'nullable|integer|min:0',
            'location'      => 'nullable|string',
            'city'          => 'nullable|string',
            'address'       => 'nullable|string',
            'status'        => 'required|string',
            'featured'      => 'nullable|boolean',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $property->update([
            'title'         => $validated['title'],
            'description'   => $validated['description'] ?? null,
            'property_type' => $validated['property_type'],
            'purpose'       => $validated['purpose'],
            'price'         => $validated['price'],
            'area'          => $validated['area'] ?? null,
            'area_unit'     => $validated['area_unit'] ?? null,
            'bedrooms'      => $validated['bedrooms'] ?? null,
            'bathrooms'     => $validated['bathrooms'] ?? null,
            'kitchens'      => $validated['kitchens'] ?? null,
            'location'      => $validated['location'] ?? null,
            'city'          => $validated['city'] ?? null,
            'address'       => $validated['address'] ?? null,
            'status'        => $validated['status'],
            'featured'      => $validated['featured'] ?? 0,
        ]);

        // Add new images without deleting existing images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image'       => $path,
                ]);
            }
        }

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Property
    |--------------------------------------------------------------------------
    */
    public function destroy(string $id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        // Owner can only delete their own properties
        $property = Property::where('user_id', $user->id)
            ->where('owner_type', 'owner')
            ->findOrFail($id);

        // Delete image files from storage
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        // Delete property; related image rows should cascade
        $property->delete();

        return redirect()
            ->route('owner.properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    public function ownerinquiries()
    {
        $userId = Auth::id();
        $inquiries = BuyerInquiry::with(['property.images', 'ownerProperty.images', 'buyer'])
            ->where(function ($query) use ($userId) {
                $query->whereHas('property', function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->where('owner_type', 'owner');
                })->orWhere(function ($sub) use ($userId) {
                    $sub->where('property_source', 'ownerproperties')
                        ->whereHas('ownerProperty', function ($op) use ($userId) {
                            $op->where('user_id', $userId);
                        });
                });
            })
            ->latest()
            ->get();

        $inquiryCount = $inquiries->count();

        return view('owner.inquiries.index', compact(
            'inquiries',
            'inquiryCount'
        ));
    }
    public function ownerinquirystatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $inquiry = BuyerInquiry::findOrFail($id);

        $inquiry->update([
            'status' => $request->status,
        ]);

        return back()->with(
            'success',
            'Inquiry status updated successfully!'
        );
    }
    public function ownerinquiriesdestroy(Request $request, $id)
    {
        BuyerInquiry::findOrFail($id)->delete();

        return back()->with('success', 'Inquiry deleted successfully!');
    }

     public function ownerinquiryreply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $inquiry = BuyerInquiry::findOrFail($id);

        $inquiry->update([
            'reply' => $request->reply,
        ]);

        return back()->with(
            'success',
            'Reply sent successfully!'
        );
    }

}

