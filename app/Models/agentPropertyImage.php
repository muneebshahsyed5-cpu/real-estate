<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agentPropertyImage extends Model
{
    use HasFactory;

    protected $table = 'agentproperty_images';

    protected $fillable = [
        'agentproperty_id',
        'image',
    ];

    public function property()
    {
        return $this->belongsTo(AgentProperty::class, 'agentproperty_id');
    }
}