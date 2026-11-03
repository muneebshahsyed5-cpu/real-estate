<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Property;
use App\Models\OwnerProperty;
use App\Models\AgentProperty;

class BuyerInquiry extends Model
{
    protected $table = 'buyer_inquiries';

    protected $fillable = [
        'buyer_id',
        'property_id',
        'property_source',
        'message',
        'status',
        'reply',
        'name',
        'email',
    ];

    /*
    |--------------------------------------------------------------------------
    | Buyer
    |--------------------------------------------------------------------------
    */

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }


    /*
    |--------------------------------------------------------------------------
    | Inquiry Property
    |--------------------------------------------------------------------------
    | Property can come from:
    | properties
    | ownerproperties
    | agentproperties
    */

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function ownerProperty()
    {
        return $this->belongsTo(OwnerProperty::class, 'property_id');
    }

    public function agentProperty()
    {
        return $this->belongsTo(AgentProperty::class, 'property_id');
    }
}
