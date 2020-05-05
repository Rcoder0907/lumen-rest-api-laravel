<?php

namespace App\Http\Controllers\v1;

use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    public function create(Request $request) {
        $getProduct = Product::find($request->product_id);

        if ($request->order_quantity > $getProduct->quantity) {
            return response()->json('Product out of stock!');
        }

        $user = \Auth::user();

        $order = new Order;
        $order->user_id = $user->id;
        $order->product_id = $request->product_id;
        $order->order_status = Order::order_status_pending;
        $order->address = $request->address;
        $order->street = $request->street;
        $order->city = $request->city;
        $order->postcode = $request->postcode;
        $order->order_quantity = $request->order_quantity;
        $order->save();
        return response()->json($order);        
    }

    public function show(Request $request) {
        $short = $request->order_status;
        if ($short) {
            $orders = Order::where(['order_status' => $short])->get();
        } else {
            $orders = Order::get();
        }
        return response()->json($orders);
    }

    public function proceed(Request $request, $id) {
        if (!$this->callAction($request)) {
            return response()->json('Access Denied!');
        }
        $status = request()->input('status');
        $orders = Order::where(['id' => $id])->update(['order_status' => $status]);
        if ($status == Order::order_status_accepted) {
            //sendEmailCode
        }
        return response()->json($orders);
    }

    public function scheduer() {
        Order::whereDate('created_at', '!=', Carbon::today())->update(['order_status' => Order::order_status_processed]);
    }

}
