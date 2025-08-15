<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    protected $fillable = ['product_id', 'discount_type', 'discount_value', 'start_date', 'end_date',];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
