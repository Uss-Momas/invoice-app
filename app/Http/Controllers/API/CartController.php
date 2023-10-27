<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "status" => "success",
            "data" => Cart::paginate(10)
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
            "products" => "required|array",
        ]);

        $cart = new Cart();
        $cart->products = json_encode($request->products);
        $total = 0;
        foreach ($request->products as $key => $product) {
            $total += $product["price"] * $product["quantity"];
        }
        $cart->total = $total;
        $cart->save();

        return response()->json([
            "message" => "Created with success",
            "data" => $cart
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return response()->json([
            "status" => "success",
            "data"  => $cart
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        $cart->products = json_encode($request->products);
        $total = 0;
        foreach ($request->products as $key => $product) {
            $total += $product["price"] * $product["quantity"];
        }
        $cart->total = $total;
        $cart->update();

        return response()->json([
            "message" => "Updated with success",
            "data" => $cart
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json([
            "message" => "Deleted with success",
        ]);
    }
}
