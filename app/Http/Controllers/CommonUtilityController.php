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
}
