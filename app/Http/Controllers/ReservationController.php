<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservationItem;


class ReservationController extends Controller
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
        $request->validate([
            'full_name'=>'required|string',
            'mobile_number'=>'required|regex:/(09)[0-9]{9}/',
            'number_of_person'=>'required|numeric',
            'reservation_date'=>'required',
            // 'reservation_time'=>'required',
            "menu" => "required",
        ]);

        $reserve = Reservation::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'mobile_number' => $request->mobile_number,
            'number_of_person' => $request->mobile_number,
            'reservation_date' => $request->reservation_date,
            // 'reservation_time' => $request->reservation_time,
            'total' => $request->total,
            'status' => 0,
        ]);

        $reserve->reservation_number = str_pad($reserve->id, 6, "0", STR_PAD_LEFT);
        $reserve->save();

        $items = $request->menu;
        foreach ($items as $key => $item) {
           ReservationItem::create([
            'image' => $item['image'],
            'reservation_id' => $reserve->id,
            'code' => $item['code'],
            'product_id'=> $item['product_id'],
            'name'=> $item['name'],
            'description' => $item['description'],
            'quantity' => $item['quantity'],
            'price'=> $item['price'],
            'food_category_id' => $item['food_category_id'],
           ]);
        }

        return response()->json($reserve, 200);

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
