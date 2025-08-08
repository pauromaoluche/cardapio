<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'client_name', 'client_phone', 'address',
        'total_value', 'delivery_fee', 'payment_type',
        'change_to', 'status'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'observation')
            ->withTimestamps();
    }
}
