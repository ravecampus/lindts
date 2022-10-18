<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserTray;

class UserTrayController extends Controller
{
    public function userListTray(){
        $id = Auth::id();
        $usert_ = UserTray::where('user_id',$id)->first();
        return response()->json($usert_, 200);
    
    }
    public function userTray(Request $request){
        $id = Auth::id();
        $usert_ = UserTray::where('user_id', $id)->first();
        if(!isset($usert_)){
            $usert_ = UserTray::create([
                'user_id'=>$id,
                'json_data'=>$request->json_data,
                ]);
        }else{
            $usert_->json_data = $request->json_data;
            $usert_->save();
        }

        return response()->json($usert_, 200);
    }

    public function deleteTray(Request $request){
        $id = Auth::id();
        $usert_ = UserTray::where('user_id', $id)->first();
        $usert_->delete();
        return response()->json(['User Deleted'], 200);
    }
}
