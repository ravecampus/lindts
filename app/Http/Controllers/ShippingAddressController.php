<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ship = ShippingAddress::where('user_id', Auth::id())->get();
        return response()->json($ship, 200);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'address' => 'required|string',
            // 'mobile_number' => 'required|regex:/(09)[0-9]{9}/',
        ]);

        $chk = ShippingAddress::where('user_id', Auth::id())->get();
        if(count($chk) <= 0 ){
            $ship = ShippingAddress::create([
                'full_name' =>$request->full_name,
                'address' =>$request->address,
                // 'mobile_number' =>$request->mobile_number,
                'user_id' =>Auth::id(),
                'default' => 1,
            ]);
        }else{
            $ship = ShippingAddress::create([
                'full_name' =>$request->full_name,
                'address' =>$request->address,
                // 'mobile_number' =>$request->mobile_number,
                'user_id' =>Auth::id(),
                'default' => 0,
            ]);
        }
       

        return response()->json($ship, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string',
            'address' => 'required|string',
            // 'mobile_number' => 'required|regex:/(09)[0-9]{9}/',
        ]);
        $ship = ShippingAddress::find($id);
        $ship->full_name = $request->full_name;
        $ship->address = $request->address;
        // $ship->mobile_number = $request->mobile_number;
        $ship->save();

        return response()->json($ship, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function defaultShip(Request $request){
        
        ShippingAddress::where('user_id', Auth::id())->update(array('default' => 0));
        $ship = ShippingAddress::find($request->id);
        $ship->default = 1;
        $ship->save();
        return response()->json($ship, 200);
        
    }

    public function authShip(){
        $ship = ShippingAddress::where('user_id', Auth::id())->where('default',1)->first();
        return response()->json($ship, 200);
    }
}
