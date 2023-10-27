<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\InvoicePaidNewNotification;
use App\Notifications\InvoicePaidNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "status"    => "success",
            "data" => Order::with("products")->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "products" => "required|array",
            "products.*.product_id" => "required|exists:products,id",
            "products.*.quantity" => "required|numeric|min:1",
            "amount" => "required|numeric|min:0",
        ]);

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->order_amount = $request->amount;
        $order->save();
        $products = [];
        // removing unecessary data before attaching to products order table
        foreach ($request->products as $product) {
            unset($product["description"]);
            unset($product["name"]);
            unset($product["price"]);
            array_push($products, $product);
        }
        $order->products()->attach($products);
        
        $user = User::find(1); // Hardcoded code to send o a user in he database;
        
        Notification::sendNow($user, new InvoicePaidNewNotification(Order::with("products")->find($order->id)));

        return response()->json([
            "message"   =>  "New Order created with success!",
            "data"  =>  $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json([
            "status"    => "success",
            "data" => Order::with("products")->find($order->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            "user_id" => "required",
            "products" => "required|array",
            "products.*.product_id" => "required|exists:products,id",
            "products.*.quantity" => "required|numeric|min:1",
            "amount" => "required|numeric|min:0",
        ]);

        $order->user_id = $request->user_id;
        $order->order_amount = $request->amount;
        $order->save();
        $order->products()->sync($request->products);

        return response()->json([
            "message"   =>  "Order Updated with success!",
            "data"  =>  $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json([
            "status"    => "success",
            "message"   => "Order deleted with success!"
        ]);
    }
}
