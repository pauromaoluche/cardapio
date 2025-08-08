<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = ['name', 'active'];

       public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}
