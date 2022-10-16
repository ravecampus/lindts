<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryFee;

class DeliveryFeeController extends Controller
{
    public function postDeliveryFee(Request $request){

        $delivery = DeliveryFee::find(1);
        $delivery->amount = $request->amount;
        $delivery->save();
        return response()->json($delivery, 200);
    }

    public function getDeliveryFee(){
        $del = DeliveryFee::find(1);
        return response()->json($del, 200);
    }
}
