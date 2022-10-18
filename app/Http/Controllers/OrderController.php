<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        $ck = $request->payment_mode;
        if($ck == 1){
            $request->validate([
                'full_name' => 'required|string',
                'delivery_address' => 'required|string',
                'mobile_number' =>'required|string',
                'trays' =>'required|array',
    
            ]);
            $order = Order::create([
                'user_id'=> Auth::id(),
                'full_name'=> $request->full_name,
                'delivery_address'=> $request->delivery_address,
                'mobile_number'=> $request->mobile_number,
                'payment_mode'=> $request->payment_mode,
                'delivery_fee'=> $request->delivery_fee,
                'total'=> $request->total,
                'grand_total'=> $request->grand_total,
                'status'=> 0,
            ]);
            $order->order_number = str_pad($order->id, 8, "0", STR_PAD_LEFT);
            $order->save();

            $trays = $request->trays;
            foreach ($trays as $key => $value) {
                OrderItem::create([
                    'image' => $value['image'],
                    'order_id' => $order->id,
                    'code' => $value['code'],
                    'product_id'=> $value['product_id'],
                    'name'=> $value['name'],
                    'description'=> $value['description'],
                    'price'=> $value['price'],
                    'quantity'=> $value['quantity'],
                    'food_category_id'=> $value['food_category_id'],
                ]);
            }
            return response()->json($order, 200);
        }else{
            $request->validate([
                'trays' =>'required|array',
            ]);
            $auth = Auth::user();
            $order = Order::create([
                'user_id'=> Auth::id(),
                'full_name'=> $auth->first_name.' '.$auth->middle_name.' '.$auth->last_name,
                'mobile_number'=> $auth->mobile_number,
                'payment_mode'=> $request->payment_mode,
                'total'=> $request->total,
                'grand_total'=> $request->grand_total,
                'status'=> 0,
            ]);
            $order->order_number = str_pad($order->id, 8, "0", STR_PAD_LEFT);
            $order->save();

            $trays = $request->trays;
            foreach ($trays as $key => $value) {
                OrderItem::create([
                    'image' => $value['image'],
                    'order_id' => $order->id,
                    'code' => $value['code'],
                    'product_id'=> $value['product_id'],
                    'name'=> $value['name'],
                    'description'=> $value['description'],
                    'price'=> $value['price'],
                    'quantity'=> $value['quantity'],
                    'food_category_id'=> $value['food_category_id'],
                ]);
            }
            return response()->json($order, 200);
        }
        
      
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
        //
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

    
}
