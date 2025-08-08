<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class MessageController extends Controller
{
    public function new_message(Request $request)
    {
        Log::driver('stderr')->error(json_encode($request->all()));
        $sid = config('twilio.sid');
        $token = config('twilio.auth_token');

        $client = new Client($sid, $token);

        try {
            $client->messages
                ->create(
                    "whatsapp:+554398628444",
                    array(
                        "from" => "whatsapp:+14155238886",
                        "body" => "Teste som"
                    )
                );

            return response("ok", 200);
        } catch (\Exception $e) {
            Log::error("Erro ao enviar mensagem: " . $e->getMessage());
            return response("Erro ao enviar mensagem", 500);
        }
    }
}
