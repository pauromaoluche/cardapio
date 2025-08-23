<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::create([
            'send_message_all_status' => false,
            'notify_new_order' => false,
            'phone_to_notify' => null,
            'email' => 'emailvirtual@hotmail.com',
            'phone' => '23554685644',
            'address' => 'Rua professira teste',
            'delivery_fee' => 0
        ]);
    }
}
