<?php

namespace App\Http\Controllers;

use App\Models\BuyerInquiry;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::with('images')->latest()->get();
        $inquiries = BuyerInquiry::count();

        return view('admin.property.index', compact('properties', 'inquiries'));
    }

    public function featured()
    {
        $properties = Property::where('featured', '1')->get();
        $inquiries = BuyerInquiry::count();

        return view('admin.featured-img', compact('properties', 'inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inquiries = BuyerInquiry::count();

        return view('admin.property.create', compact('inquiries'));
    }

    public function store(Request $request)
    {
        // 1. Logged-in user
        $user = Auth::user();

        // 2. Check user role using Spatie Permission
        if ($user->hasRole('admin')) {
            $ownerType = 'admin';
        } elseif ($user->hasRole('owner')) {
            $ownerType = 'owner';
        } elseif ($user->hasRole('agent')) {
            $ownerType = 'agent';
        } else {
            abort(403, 'Unauthorized action.');
        }

        // 3. Validate property data
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
            // 'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // 4. Create property
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

        // 5. Upload property images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image' => $path,
                ]);
            }
        }

        // 6. Success message
        return redirect()->route('admin.dashboard')
            ->with('success', 'Property added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property = Property::findorfail($id);

        return view('admin.property.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'property_type' => 'required|string',
            'purpose' => 'required|string',
            'price' => 'required|numeric',
            'area' => 'nullable|numeric',
            'area_unit' => 'nullable|string',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'kitchens' => 'nullable|integer',
            'location' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'status' => 'required|string',
            'featured' => 'nullable|boolean',

            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

        // Property find karo
        $property = Property::findOrFail($id);

        // =========================
        // PROPERTY UPDATE
        // =========================

        $property->update([

            'title' => $request->title,

            'description' => $request->description,

            'property_type' => $request->property_type,

            'purpose' => $request->purpose,

            'price' => $request->price,

            'area' => $request->area,

            'area_unit' => $request->area_unit,

            'bedrooms' => $request->bedrooms,

            'bathrooms' => $request->bathrooms,

            'kitchens' => $request->kitchens,

            'location' => $request->location,

            'city' => $request->city,

            'address' => $request->address,

            'status' => $request->status,

            'featured' => $request->has('featured') ? 1 : 0,

        ]);

        // =========================
        // IMAGES UPDATE
        // =========================

        if ($request->hasFile('images')) {

            // Old images database se delete
            $property->images()->delete();

            // New images save
            foreach ($request->file('images') as $image) {

                $path = $image->store('properties', 'public');

                PropertyImage::create([

                    'property_id' => $property->id,

                    'image' => $path,

                ]);
            }
        }

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::findorfail($id);
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property Deleted successfully!');
    }

    // Agents//

    public function agents()
    {
        $agents = User::role('agent')->get();

        return view('admin.agents', compact('agents'));
    }

    public function agentshow(string $id)
    {
        $agent = User::role('agent')->findOrFail($id);

        return view('admin.agent.show', compact('agent'));
    }

    public function agentedit(string $id)
    {
        $agent = User::role('agent')->findOrFail($id);

        return view('admin.agent.edit', compact('agent'));
    }

    public function agentupdate(Request $request, string $id)
    {
        $agent = User::role('agent')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        $agent->address = $request->address;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('agents', 'public');

            $agent->image = 'storage/'.$path;
        }

        $agent->save();

        return redirect()
            ->route('admin.agents')
            ->with('success', 'Agent updated successfully!');
    }

    public function agentdelete(string $id)
    {
        $agent = User::role('agent')->findOrFail($id);

        $agent->delete();

        return redirect()
            ->route('admin.agents')
            ->with('success', 'Agent deleted successfully!');
    }

    public function clients()
    {

        $buyers = User::role('buyer')->get();

        return view('admin.clients', compact('buyers'));
    }

    public function clientshow(string $id)
    {

        $buyer = User::role('buyer')->findorfail($id);

        return view('admin.client.view', compact('buyer'));
    }

    public function clientedit(string $id)
    {
        $buyer = User::role('buyer')->findorfail($id);

        return view('admin.client.edit', compact('buyer'));
    }

    public function clientupdate(Request $request, string $id)
    {
        $buyer = User::role('buyer')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $buyer->name = $request->name;
        $buyer->email = $request->email;
        $buyer->phone = $request->phone;
        $buyer->address = $request->address;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('clients', 'public');

            $buyer->image = 'storage/'.$path;
        }

        $buyer->save();

        return redirect()
            ->route('admin.clients')
            ->with('success', 'Client updated successfully!');
    }

    public function clientdelete(string $id)
    {
        $buyer = User::role('buyer')->findOrFail($id);

        $buyer->delete();

        return redirect()
            ->route('admin.clients')
            ->with('success', 'Buyer deleted successfully!');
    }

    public function inquiries()
    {
        $inquiries = BuyerInquiry::with('property.images')->latest()->get();

        return view('admin.inquiries', compact('inquiries'));
    }
}
