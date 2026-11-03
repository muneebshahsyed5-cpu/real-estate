<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentProperty extends Model
{
    use HasFactory;

    protected $table = 'agentproperties';

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
    return $this->hasMany(agentPropertyImage::class, 'agentproperty_id');
}

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}