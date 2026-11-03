<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Property extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'property_type',
        'purpose',
        'price',
        'area',
        'area_unit',
        'bedrooms',
        'bathrooms',
        'kitchens',
        'location',
        'city',
        'address',
        'status',
        'featured',
        'owner_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
 public function inquiries()
{
    return $this->hasMany(BuyerInquiry::class, 'property_id');
}

  public function isSavedByBuyer()
    {
        return SavedProperty::where('buyer_id', Auth::id())
            ->where('property_id', $this->id)
            ->exists();
    }
}
