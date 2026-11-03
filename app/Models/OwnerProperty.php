<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerProperty extends Model
{

 protected $table = 'ownerproperties';
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
    ];
      public function images()
{
    return $this->hasMany(ownerPropertyImage::class, 'ownerproperty_id');
}
 public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
