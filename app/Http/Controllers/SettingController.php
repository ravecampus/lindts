<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function postSetting(Request $request){

        $request->validate([
            'mobile_number' => 'regex:/(09)[0-9]{9}/',
        ]);
        $delivery = Setting::find(1);
        $delivery->mobile_number = $request->mobile_number;
        $delivery->schedule = $request->schedule;
        $delivery->save();
        return response()->json($delivery, 200);
    }

    public function getSetting(){
        $del = Setting::find(1);
        return response()->json($del, 200);
    }
}
