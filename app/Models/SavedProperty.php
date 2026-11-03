<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedProperty extends Model
{
    protected $fillable = [
        'buyer_id',
        'property_id',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
