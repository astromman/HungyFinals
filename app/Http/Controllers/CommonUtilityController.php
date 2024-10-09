<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CommonUtilityController extends Controller
{
    public function addAuditTrail($userId, $actionType, $description)
    {
        if ($actionType == 1) {
            $action = "ADD";
        } elseif ($actionType == 2) {
            $action = "UPDATE";
        } elseif ($actionType == 3) {
            $action = "DELETE";
        }

        $audit = new Audit();
        $audit->user_id = $userId;
        $audit->action = $action;
        $audit->description = $description;
        $audit->created_at = now();
        $audit->updated_at = now();
        $audit->save();
    }

    public function helloWorld()
    {
        return ('HelloWorld <br>You\'ve discorved my easter egg. <br>4:12 Non-Stop Hamilton musical (I\'m the Hamilton of this system) <br>Contact me for your prize<br>09195193885 / lloydadrianlindo25@gmail.com <br>- Lindope 10/01/2024');
    }
}
