<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\OrderItem;
use App\Models\ReservationItem;
use App\Models\Product;


class DashboardController extends Controller
{
    public function dashboard(){
        $user = User::where('role', 0)->get();
        $salesorder = Order::where('status', 4)->get();
        $salesreserve = Reservation::where('status', 3)->get();
        $product = Product::where('deleted', 0)->get();
        $orderitem = OrderItem::all();
        $reserveitem = ReservationItem::all();

        $total = 0;
        foreach ($salesorder as $key => $value) {
            $total += $value['grand_total'];
        }
        $total2 = 0;
        foreach ($salesreserve as $key => $value) {
            $total2 += $value['total'];
        }
        $total3 = 0;
        foreach ($orderitem as $key => $value) {
            $total3 += $value['quantity'];
        }
        $total4 = 0;
        foreach ($reserveitem as $key => $value) {
            $total4 += $value['quantity'];
        }
        $itemsold = $total3 + $total4;

        $gt = ($total + $total2);
        return response()->json([
            'user'=>count($user), 
            'sales'=>$gt, 
            'products'=>count($product),
            'item_sold' => $itemsold
        ], 200);
    }
}
