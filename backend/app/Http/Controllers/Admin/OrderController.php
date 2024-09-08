<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller {

  public function index() {
    $orders = Order::with(['products', 'user', 'coupon'])->latest()->get();
    return response()->json($orders);
  }

  public function orderInfo() {
    $todayOrders = Order::whereDay('created_at', Carbon::today())->get();
    $yesterdayOrders = Order::whereDay('created_at', Carbon::yesterday())->get();
    $monthOrders = Order::whereMonth('created_at', Carbon::now()->month)->get();
    $yearOrders = Order::whereYear('created_at', Carbon::now()->year)->get();

    return response()->json([
      'todayOrders' => $todayOrders,
      'yesterdayOrders' => $yesterdayOrders,
      'monthOrders' => $monthOrders,
      'yearOrders' => $yearOrders,
    ]);
  }

  public function updateDeliveredAtDate(Order $order) {
    $order->update([
      'delivered_at' => Carbon::now()
    ]);
    return response()->json($order);
  }


  public function destroy(Order $order) {
    $order->delete();
    return response()->noContent();
  }
}
