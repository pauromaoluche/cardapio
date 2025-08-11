<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;

class PromotionService
{
    public function getAll(): Collection
    {
        return Promotion::with('images')->get();
    }
}
