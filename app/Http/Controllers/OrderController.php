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
    public function index(Request $request)
    {
        $columns = ['order_number',null,null,null,null,null, 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;
        if($filter == 1){
            $query = Order::with('order_items')->where('status', '!=', 4)->where('status', '!=', 5)->where('status', '!=', 0)->where('payment_mode', $filter)->orderBy($columns[$column], $dir);
        }else if($filter == 2){
            $query = Order::with('order_items')->where('status', '!=', 4)->where('status', '!=', 5)->where('payment_mode', $filter)->orderBy($columns[$column], $dir);
        }else if($filter == 3){
            $query = Order::with('order_items')->where('status', 4)->orderBy($columns[$column], $dir);
        }
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('order_number', 'like', '%'.$searchValue.'%')
                ->orWhere('full_name', 'like', '%'.$searchValue.'%');
            });
        }
       
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
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

    public function orderPayment(Request $request){
        $id = Auth::id();
        $order = Order::where('user_id', $id)->where('status',0)->where('order_number', $request->order_number)->first();
        return response()->json($order, 200);
    }

    public function authOrders(Request $request){

        $columns = ['order_number',null,null,null,null,null, 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $auth = Auth::id();
        $filter = $request->filter;
        $searchValue = $request->search;
        if($filter == 0){
            $query = Order::with('order_items')->where('status', '!=', 4)->where('status', '!=', 5)->where('user_id', $auth)->orderBy($columns[$column], $dir);
        }else if($filter == 4){
            $query = Order::with('order_items')->where('status', 4)->where('user_id', $auth)->orderBy($columns[$column], $dir);
        }else if($filter == 3){
            $query = Order::with('order_items')->where('status', 5)->where('user_id', $auth)->orderBy($columns[$column], $dir);
        }else{
            $query = Order::with('order_items')->where('status', '!=', 4)->where('status', '!=', 5)->where('user_id', $auth)->where('payment_mode', $filter)->orderBy($columns[$column], $dir);
        }
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('order_number', 'like', '%'.$searchValue.'%')
                ->orWhere('full_name', 'like', '%'.$searchValue.'%');
            });
        }
       
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function setStatus(Request $request){
        $order = Order::find($request->id);
        $order->status = $request->status;
        $order->save();

        return response()->json($order, 200);
    }
    
}
