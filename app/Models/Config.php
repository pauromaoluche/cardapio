<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = ['send_message_all_status', 'notify_new_order', 'phone_to_notify', 'email', 'phone', 'address', 'delivery_fee'];
}
