<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function sendSmsNotificaition()
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('a12f1161', 'cvjs9NzzwtzSDNrF');
        $client = new \Nexmo\Client($basic);
 
        $message = $client->message()->send([
            'to' => '919721697989',
            'from' => 'John Doe',
            'text' => 'A simple hello message sent from Vonage SMS API'
        ]);
 
        dd('SMS message has been delivered.');
    }
}