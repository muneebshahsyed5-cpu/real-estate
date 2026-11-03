<?php

namespace App\Http\Controllers;

use App\Models\SavedProperty;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class SavedPropertyController extends Controller
{
    public function toggle(Property $property)
    {
        $saved = SavedProperty::where('buyer_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();

        if ($saved) {

            $saved->delete();

            return back()->with(
                'success',
                'Property removed from saved properties.'
            );
        }

        SavedProperty::create([
            'buyer_id' => Auth::id(),
            'property_id' => $property->id,
        ]);

        return back()->with(
            'success',
            'Property saved successfully!'
        );
    }



     public function usertoggle(Property $property)
    {
        $saved = SavedProperty::where('buyer_id', Auth::id())
            ->where('property_id', $property->id)
            ->first();

        if ($saved) {

            $saved->delete();

            return back()->with(
                'success',
                'Property removed from saved properties.'
            );
        }

        SavedProperty::create([
            'buyer_id' => Auth::id(),
            'property_id' => $property->id,
        ]);

        return back()->with(
            'success',
            'Property saved successfully!'
        );
        }


    public function index()
    {
        $savedProperties = SavedProperty::with(['property.images'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get();

        if (Auth::user() && Auth::user()->hasRole('buyer')) {
            return view('buyer.saved-properties', compact('savedProperties'));
        }

        return view('user.saved-properties', compact('savedProperties'));
    }

    public function usersaveindex()
    {
        $savedProperties = SavedProperty::with('property.images')
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get();

        return view(
            'user.saved-properties',
            compact('savedProperties')
        );
    }
}
