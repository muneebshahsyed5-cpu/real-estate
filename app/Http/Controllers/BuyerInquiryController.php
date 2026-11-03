<?php

namespace App\Http\Controllers;

use App\Models\BuyerInquiry;
use App\Models\Property;
use App\Models\RecentlyViewedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerInquiryController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::with('images')->latest()->get();
        $featuredimage = Property::with('images')->where('featured', '1')->latest()->get();
        return view('buyer.properties.index', compact('properties', 'featuredimage'));
    }

    public function create(Property $property)
    {
        return view('buyer.inquires.create', compact('property'));
    }

    public function store(Request $request, $property = null)
    {
        if (!$request->has('property_id') && $property) {
            $propertyId = $property instanceof Property ? $property->id : $property;
            $request->merge(['property_id' => $propertyId]);
        }

        if (!$request->has('property_source')) {
            $request->merge(['property_source' => 'properties']);
        }

        $request->validate([
            'property_id' => 'required|integer',
            'property_source' => 'required|in:properties,ownerproperties,agentproperties',
            'message' => 'required|string',
        ]);

        BuyerInquiry::create([
            'buyer_id' => Auth::id(),
            'property_id' => $request->property_id,
            'property_source' => $request->property_source,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        // Buyer
        if (Auth::user()->hasRole('buyer')) {
            return redirect()
                ->route('buyer.inquiries.index')
                ->with('success', 'Your inquiry has been sent successfully!');
        }

        // Normal User
        if (Auth::user()->hasRole('user')) {
            return redirect()
                ->route('user.inquiries.index')
                ->with('success', 'Your inquiry has been sent successfully!');
        }

        return back()->with('success', 'Your inquiry has been sent successfully!');
    }
    public function inquiresindex()
    {
        $inquiries = BuyerInquiry::where('buyer_id', Auth::id())
            ->latest()
            ->get();

        return view('buyer.inquires.index', compact('inquiries'));
    }
    public function userInquiries()
    {
        $inquiries = BuyerInquiry::where('buyer_id', Auth::id())
            ->latest()
            ->get();

        return view('user.inquires.index', compact('inquiries'));
    }



    public function agentinquiries()
    {
        $userId = Auth::id();

        $inquiries = BuyerInquiry::with(['property.images', 'agentProperty.images', 'buyer'])
            ->where(function ($q) use ($userId) {
                $q->whereHas('property', function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->where('owner_type', 'agent');
                })->orWhere(function ($sub) use ($userId) {
                    $sub->where('property_source', 'agentproperties')
                        ->whereHas('agentProperty', function ($ap) use ($userId) {
                            $ap->where('user_id', $userId);
                        });
                });
            })
            ->latest()
            ->get();

        $inquiryCount = $inquiries->count();

        return view('agent.inquiries.index', compact(
            'inquiries',
            'inquiryCount'
        ));
    }


    public function updateStatus(Request $request, $id)
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


    public function agentupdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $inquiry = $id instanceof BuyerInquiry ? $id : BuyerInquiry::findOrFail($id);

        $inquiry->update([
            'status' => $request->status,
        ]);

        return back()->with(
            'success',
            'Inquiry status updated successfully!'
        );
    }
    public function destroy(Request $request, $id)
    {
        BuyerInquiry::findOrFail($id)->delete();

        return back()->with('success', 'Inquiry deleted successfully!');
    }
    public function agentdestroy(Request $request, $id)
    {
        BuyerInquiry::findOrFail($id)->delete();

        return back()->with('success', 'Inquiry deleted successfully!');
    }

    public function reply(Request $request, $id)
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

    public function agentreply(Request $request, $id)
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



    public function show(property $property)
    {
        if (Auth::check()) {
            RecentlyViewedProperty::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'property_id' => $property->id
                ],
                [

                    'updated_at' => now(),
                ]
            );
            // dd($property);

            return view('buyer.properties.show', compact('property'));
        }
    }
}
