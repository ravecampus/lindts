<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Session;

class AuthController extends Controller
{
    public function signup(Request $request){
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|numeric',
            'address' => 'required|string',
            'mobile_number' => 'required|regex:/(09)[0-9]{9}/',
            'email' => 'required|string|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'address' => $request->address,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'role' =>0,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        return response()->json($user, 200);
   }

   public function signin(LoginRequest $request){
        $credentials = $request->getCredentials();

        if(!Auth::attempt($credentials)):
            // $request->session()->regenerate();
            $errors = ['errors'=>['errs' => ['Incorrect username and password!']]];
            return response()->json($errors,401);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $a = Auth::user();
        return response()->json($a,200);
   }

   public function logout(){
       try {
           Session::flush();
           $success = true;
           $message = 'Successfully logged out';
       } catch (\Illuminate\Database\QueryException $ex) {
           $success = false;
           $message = $ex->getMessage();
       }

       // response
       $response = [
           'success' => $success,
           'message' => $message,
       ];
       return response()->json($response);
   }

   public function userProfile(Request $request){

        $request->validate([
            'username' =>'required|string',
            'first_name' =>'required|string',
            'last_name' =>'required|string',
            'address' =>'required|string',
            'age' =>'required|numeric',
            'mobile_number' => 'required|regex:/(09)[0-9]{9}/',
            'email' =>'required|email',
        ]);

        $id = Auth::id();
        $user = User::find($id);
        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->address = $request->address;
        $user->age = $request->age;
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->save();
        return response()->json($user, 200);
   }

   public function userPassword(Request $request){
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $user = User::find(Auth::id());
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json($user, 200);
    }

    public function adminProfile(Request $request){
        $request->validate([
            'username' =>'required|string',
            'first_name' =>'required|string',
            'last_name' =>'required|string',
        ]);

        $id = Auth::id();
        $user = User::find($id);
        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();
        return response()->json($user, 200);
    }

}
