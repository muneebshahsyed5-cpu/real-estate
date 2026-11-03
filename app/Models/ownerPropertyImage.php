<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ownerPropertyImage extends Model
{
      protected $table = 'ownerproperty_images';

    protected $fillable = [
        'ownerproperty_id',
        'image',
    ];

    public function property()
    {
        return $this->belongsTo(OwnerProperty::class, 'ownerproperty_id');
    }
}
