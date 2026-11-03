<?php

namespace App\Http\Controllers;

use App\Models\RecentlyViewedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecentlyviewController extends Controller
{
   public function index()
    {
        $recentlyViewed = RecentlyViewedProperty::with([
            'property.images'
        ])
        ->where('user_id', Auth::id())
        ->latest('updated_at')
        ->get();

        return view('buyer.properties.recently', compact('recentlyViewed'));
    }
}
