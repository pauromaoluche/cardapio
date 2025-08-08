<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatusMessageController extends Controller
{
    public function status_message(Request $request)
    {
        Log::driver('stderr')->error('Status');
        Log::driver('stderr')->error(json_encode($request->all()));
    }
}
