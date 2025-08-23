<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ConfigFormValidation extends Form
{

    public $send_message_all_status;
    public $notify_new_order;
    public $phone_to_notify;
    public $email;
    public $phone;
    public $address;
    public $delivery_fee;

    public function rules()
    {
        return [
            'send_message_all_status' => 'boolean',
            'notify_new_order' => 'boolean',
            'phone_to_notify' => 'required_if:notify_new_order,true|nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'delivery_fee' => 'numeric|min:0|max:999999.99',
        ];
    }
}
