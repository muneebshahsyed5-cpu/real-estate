<?php

use App\Http\Controllers\BuyerInquiryController;
use App\Http\Controllers\ProfileController;
use App\Models\AgentProperty;
use App\Models\BuyerInquiry;
use App\Models\OwnerProperty;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home
// Route::get('/', function () {
//     $properties = Property::with('images')->latest()->get();
//     $agentproperties = AgentProperty::with('images')->latest()->get();
//     $ownerproperties = OwnerProperty::with('images')->latest()->get();


//     $featuredimage = Property::with('images')->where('featured', '1')->latest()->get();
//     $agentfeaturedimage = AgentProperty::with('images')->where('featured', '1')->latest()->get();
//     $ownerfeaturedimage = OwnerProperty::with('images')->where('featured', '1')->latest()->get();


//     return view('home',compact('properties','agentproperties','ownerproperties','featuredimage','ownerfeaturedimage','$agentfeaturedimage'));
// })->middleware('auth')->name('home');






Route::get('/', function () {

    // Admin, Owner aur Agent ki tamam properties
    $properties = Property::with('images')
        ->latest()
        ->get();

    $locationCounts = Property::select('location')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('location')
        ->get();


    // Admin, Owner aur Agent ki featured properties
    $propertiesfeatured = Property::with('images')
        ->where('featured', 1)
        ->latest()
        ->get();
    $user = User::all();

    return view('home', compact(
        'properties',
        'propertiesfeatured',
        'user',
        'locationCounts'
    ));
})->middleware('auth')->name('home');


Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/admin/dashboard', function () {
    $totalProperties = Property::count();
    $activeProperties = Property::where('status', 'active')->count();
    $featuredProperties = Property::where('featured', 1)->count();
    $totalUsers = User::count();
    $recentProperties = Property::with('images')->latest()->take(5)->get();
    $inquiries = BuyerInquiry::count();

    return view('admin.dashboard', compact('totalProperties', 'activeProperties', 'featuredProperties', 'totalUsers', 'recentProperties', 'inquiries'));
})->name('admin.dashboard');

Route::get('/owner/dashboard', function () {
    $userId = Auth::id();

    $totalProperties = Property::where('user_id', $userId)->where('owner_type', 'owner')->count()
        + OwnerProperty::where('user_id', $userId)->count();

    $activeProperties = Property::where('user_id', $userId)->where('owner_type', 'owner')->where('status', 'active')->count()
        + OwnerProperty::where('user_id', $userId)->where('status', 'active')->count();

    $featuredProperties = Property::where('user_id', $userId)->where('owner_type', 'owner')->where('featured', 1)->count()
        + OwnerProperty::where('user_id', $userId)->where('featured', 1)->count();

    $inquiryCount = BuyerInquiry::where(function ($q) use ($userId) {
        $q->whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('owner_type', 'owner');
        })->orWhere(function ($sub) use ($userId) {
            $sub->where('property_source', 'ownerproperties')
                ->whereHas('ownerProperty', function ($op) use ($userId) {
                    $op->where('user_id', $userId);
                });
        });
    })->count();

    $recentProperties = Property::with('images')
        ->where('user_id', $userId)
        ->where('owner_type', 'owner')
        ->latest()
        ->take(6)
        ->get();

    if ($recentProperties->isEmpty()) {
        $recentProperties = OwnerProperty::with('images')
            ->where('user_id', $userId)
            ->latest()
            ->take(6)
            ->get();
    }

    return view('owner.dashboard', compact(
        'totalProperties',
        'activeProperties',
        'featuredProperties',
        'inquiryCount',
        'recentProperties'
    ));
})->middleware('auth')->name('owner.dashboard');

Route::get('/agent/dashboard', function () {
    $userId = Auth::id();

    $totalProperties = AgentProperty::where('user_id', $userId)->count()
        + Property::where('user_id', $userId)->where('owner_type', 'agent')->count();

    $activeProperties = AgentProperty::where('user_id', $userId)->where('status', 'active')->count()
        + Property::where('user_id', $userId)->where('owner_type', 'agent')->where('status', 'active')->count();

    $featuredProperties = AgentProperty::where('user_id', $userId)->where('featured', 1)->count()
        + Property::where('user_id', $userId)->where('owner_type', 'agent')->where('featured', 1)->count();

    $totalUsers = User::count();

    $property = AgentProperty::with('images')
        ->where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();

    if ($property->isEmpty()) {
        $property = Property::with('images')
            ->where('user_id', $userId)
            ->where('owner_type', 'agent')
            ->latest()
            ->take(5)
            ->get();
    }

    $inquiryCount = BuyerInquiry::where(function ($q) use ($userId) {
        $q->whereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('owner_type', 'agent');
        })->orWhere(function ($sub) use ($userId) {
            $sub->where('property_source', 'agentproperties')
                ->whereHas('agentProperty', function ($ap) use ($userId) {
                    $ap->where('user_id', $userId);
                });
        });
    })->count();

    return view('agent.dashboard', compact('totalProperties', 'activeProperties', 'featuredProperties', 'totalUsers', 'property', 'inquiryCount'));
})->middleware('auth')->name('agent.dashboard');

Route::get('/buyer/dashboard', function () {
    return view('buyer.dashboard');
})->name('buyer.dashboard');

Route::get('/user/dashboard', function () {
    return view('user.index');
})->middleware('auth')->name('user.dashboard');

// Route::get('/userdashboard', function () {
//     return view('user.dashboard');
// })->name('userdashboad');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::get('/user/inquiries', [BuyerInquiryController::class, 'userInquiries'])
        ->name('user.inquiries.index');
});



require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/buyer.php';
require __DIR__ . '/agent.php';
require __DIR__ . '/owner.php';
require __DIR__ . '/savedproperty.php';



Route::get('modify-existing-property', function () {
    $properties = Property::get();

    foreach ($properties as $property) {
    }
});
