<?php

namespace App\Http\Controllers;

use App\Models\BuyerInquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Display the admin profile overview page.
     */
    public function index(): View
    {
        $Profile = User::findOrFail(Auth::id());

        try {
            $totalAgents = User::role('agent')->count();
        } catch (\Throwable $e) {
            $totalAgents = User::where('role', 'agent')->orWhere('role', 1)->count();
        }

        try {
            $totalBuyers = User::role('buyer')->count();
        } catch (\Throwable $e) {
            $totalBuyers = User::where('role', 'buyer')->orWhere('role', 2)->count();
        }

        $stats = [
            'totalProperties' => Property::count(),
            'activeProperties' => Property::where('status', 'active')->count(),
            'totalAgents' => $totalAgents,
            'totalBuyers' => $totalBuyers,
            'totalInquiries' => BuyerInquiry::count(),
            'pendingInquiries' => BuyerInquiry::where('status', 'pending')->count(),
        ];

        return view('admin.profile.index', compact('Profile', 'stats'));
    }

    /**
     * Update the admin profile details and avatar.
     */
    public function update(Request $request): RedirectResponse
    {
        $admin = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$admin->id,
            'phone' => 'nullable|string|max:25',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->address = $request->address;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $admin->image = 'storage/'.$path;
        }

        $admin->save();

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Admin profile updated successfully!');
    }

    /**
     * Update the admin account password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = User::findOrFail(Auth::id());
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()
            ->route('admin.profile.index')
            ->with('success', 'Password updated successfully!');
    }
}
